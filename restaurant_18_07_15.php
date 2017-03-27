<?php
ob_start();
session_start();

$session_id = session_id();
$_SESSION['cart_rest_id'] = $_REQUEST['id'];

$ses_rest_id = $_SESSION['cart_rest_id'];


//print_r($_SESSION);
include('admin/lib/conn.php');
include("includes/rest_header.php");
include("includes/functions.php");

//include("search_compete.php");
//echo getRestaurantRating($_REQUEST['id']);

function getTimezone($location) {
    $location = urlencode($location);
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address={$location}&sensor=false";
    $data = file_get_contents($url);

    // Get the lat/lng out of the data
    $data = json_decode($data);
    if (!$data)
        return false;
    if (!is_array($data->results))
        return false;
    if (!isset($data->results[0]))
        return false;
    if (!is_object($data->results[0]))
        return false;
    if (!is_object($data->results[0]->geometry))
        return false;
    if (!is_object($data->results[0]->geometry->location))
        return false;
    if (!is_numeric($data->results[0]->geometry->location->lat))
        return false;
    if (!is_numeric($data->results[0]->geometry->location->lng))
        return false;
    $lat = $data->results[0]->geometry->location->lat;
    $lng = $data->results[0]->geometry->location->lng;

    // get the API response for the timezone
    $timestamp = time();
    $timezoneAPI = "https://maps.googleapis.com/maps/api/timezone/json?location={$lat},{$lng}&sensor=false&timestamp={$timestamp}";
    $response = file_get_contents($timezoneAPI);
    if (!$response)
        return false;
    $response = json_decode($response);
    if (!$response)
        return false;
    if (!is_object($response))
        return false;
    if (!is_string($response->timeZoneId))
        return false;

    return $response->timeZoneId;
}
?>
<?php
/* if($_REQUEST['order'] == 'cancel'){
  mysql_query("DELETE FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_REQUEST['id']."'");
  header("location:restaurant.php?id=".$_REQUEST['id']."");
  } */

if ($_REQUEST['menu_del_id'] != '' && $_REQUEST['delete_item'] == 'delete') {
    $sql_del_menu_item = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE id = '" . $_REQUEST['menu_del_id'] . "' ");
    header("location:restaurant.php?id=" . $_REQUEST['id'] . "&del_item_succ=1");
}

if ($_REQUEST['menu_del_id'] != '' && $_REQUEST['sub_item'] == 'sub') {
    $sql_sel = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE id = '" . $_REQUEST['menu_del_id'] . "' "));

    if ($sql_sel['quantity'] == '1') {
        $sql_del = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE id = '" . $_REQUEST['menu_del_id'] . "' ");
    } else {
        $sql_del_menu_item = mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity - 1 WHERE id = '" . $_REQUEST['menu_del_id'] . "' ");
    }

    header("location:restaurant.php?id=" . $_REQUEST['id'] . "&qty_upd_succ=1");
}

if ($_REQUEST['menu_del_id'] != '' && $_REQUEST['add_item'] == 'add') {
    $sql_del_menu_item = mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity + 1 WHERE id = '" . $_REQUEST['menu_del_id'] . "' ");
    header("location:restaurant.php?id=" . $_REQUEST['id'] . "&qty_upd_succ=1");
}

if ($_REQUEST['menu_del_id'] != '' && $_REQUEST['delete_item'] == 'delete') {
    $sql_del_menu_item = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE id = '" . $_REQUEST['menu_del_id'] . "' ");
    header("location:restaurant.php?id=" . $_REQUEST['id'] . "&del_item_succ=1");
}

/*if ($_REQUEST['use_coupon'] != '') {
    $sql_use_coupon = mysql_query("UPDATE restaurant_coupon SET coupon_print = coupon_print-1 WHERE id = '" . $_REQUEST['use_coupon'] . "'");
    header("location:restaurant.php?id=" . $_REQUEST['restaurant_id'] . "&cou_use=1");
}*/

if ($_REQUEST['sub'] == 'sub') {
    $sql_select_item = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE id = '" . $_REQUEST['cart_id'] . "'"));


    if ($sql_select_item['quantity'] == 1) {
        mysql_query("DELETE FROM restaurant_menuitem_cart WHERE id = '" . $_REQUEST['cart_id'] . "'");
    } else {
        mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity-1 WHERE id = '" . $_REQUEST['cart_id'] . "'");
    }

    $sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '" . $session_id . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
    $num_rows = mysql_num_rows($sql_select_cart_items);

    $cart_amt = 0;
    while ($array_cart_items = mysql_fetch_array($sql_select_cart_items)) {
        $cart_amt = $cart_amt + ($array_cart_items['price'] * $array_cart_items['quantity']);
    }

    if ($_SESSION['coupon_code' . $ses_rest_id] != '') {
        if ($num_rows > 0) {
            $sql_sel_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '" . $_SESSION['coupon_code' . $ses_rest_id] . "' AND restaurant_id = '" . $_REQUEST['id'] . "'"));

            if ($sql_sel_coupon['minimum_order_amount'] < $cart_amt) {
                if ($sql_sel_coupon['discount'] != 0.00) {
                    $_SESSION['coupon_discount' . $ses_rest_id] = number_format(($sql_sel_coupon['discount'] * $cart_amt) / 100, 2);
                } else {
                    $_SESSION['coupon_discount' . $ses_rest_id] = number_format($sql_sel_coupon['coupon_price'], 2);
                }
            } else {
                $_SESSION['coupon_discount' . $ses_rest_id] = '';
                $_SESSION['coupon_code' . $ses_rest_id] = '';
            }
        } else {
            $_SESSION['coupon_discount' . $ses_rest_id] = '';
            $_SESSION['coupon_code' . $ses_rest_id] = '';
        }
    }


    if ($_SESSION['reward_point' . $ses_rest_id] != '') {

        if ($num_rows > 0) {
            $_SESSION['reward_point' . $ses_rest_id] = number_format(($cart_amt * $_SESSION['user_reward_point' . $ses_rest_id]) / 100, 2);
        }
    } else {
        $_SESSION['reward_point' . $ses_rest_id] = '';
        $_SESSION['user_reward_point' . $ses_rest_id] = '';
    }

    header("location:restaurant.php?id=" . $_REQUEST['id'] . "#tab");
}


if ($_REQUEST['add'] == 'add') {
    mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity+1 WHERE id = '" . $_REQUEST['cart_id'] . "'");

    $sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '" . $session_id . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
    $num_rows = mysql_num_rows($sql_select_cart_items);

    $cart_amt = 0;
    while ($array_cart_items = mysql_fetch_array($sql_select_cart_items)) {
        $cart_amt = $cart_amt + ($array_cart_items['price'] * $array_cart_items['quantity']);
    }

    if ($_SESSION['coupon_code' . $ses_rest_id] != '') {
        $sql_sel_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '" . $_SESSION['coupon_code' . $ses_rest_id] . "' AND restaurant_id = '" . $_REQUEST['id'] . "'"));

        if ($sql_sel_coupon['discount'] != 0.00) {
            $_SESSION['coupon_discount' . $ses_rest_id] = number_format(($sql_sel_coupon['discount'] * $cart_amt) / 100, 2);
        } else {
            $_SESSION['coupon_discount' . $ses_rest_id] = number_format($sql_sel_coupon['coupon_price'], 2);
        }
    }

    if ($_SESSION['reward_point' . $ses_rest_id] != '') {

        if ($num_rows > 0) {
            $_SESSION['reward_point' . $ses_rest_id] = number_format(($cart_amt * $_SESSION['user_reward_point' . $ses_rest_id]) / 100, 2);
        }
    } else {
        $_SESSION['reward_point' . $ses_rest_id] = '';
        $_SESSION['user_reward_point' . $ses_rest_id] = '';
    }


    header("location:restaurant.php?id=" . $_REQUEST['id'] . "#tab");
}


$sql_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '" . $_REQUEST['id'] . "'"));

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

if ($_REQUEST['submit_del_grp'] == 'VERIFY ADDRESS') {
    unset($_SESSION['del_charge' . $ses_rest_id . '_' . $_SESSION['group_order_details_id' . $ses_rest_id]]);

    $address = $_REQUEST['address_grp'];

    $array_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $_REQUEST['hid_rest_id'] . "'"));

    $rest_address = $array_basic_info['restaurant_address'] . "," . $array_basic_info['restaurant_city'] . "," . $array_basic_info['restaurant_state'] . "," . $array_basic_info['restaurant_zip'] . "," . $array_basic_info['restaurant_country'];

    $start = str_replace(' ', '+', $rest_address);
    $finish = str_replace(' ', '+', $address);


    $url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $start . '&destinations=' . $finish . '&mode=driving&language=en&sensor=false';
    $data = file_get_contents($url);
    $data = utf8_decode($data);
    $obj = json_decode($data);

    $distance = 0.621371 * ($obj->rows[0]->elements[0]->distance->text);

    $rest_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '" . $_REQUEST['hid_rest_id'] . "'"));

    if ($distance == 0) {
        $error_msg1 = 1;
    } else {
        $sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $_REQUEST['hid_rest_id'] . "' ORDER BY delivery_range");
        while ($array_del_charge = mysql_fetch_array($sql_del_crge)) {
            if ($distance <= $array_del_charge['delivery_range']) {
                $_SESSION['del_charge' . $ses_rest_id . '_' . $_SESSION['group_order_details_id' . $ses_rest_id]] = $array_del_charge['delivery_charge'];
                break;
            }
        }

        $sql_del_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $_REQUEST['hid_rest_id'] . "' ORDER BY delivery_range DESC LIMIT 0,1"));

        if ($distance <= $sql_del_charge['delivery_range']) {
            if ($_SESSION['customer_id'] != '') {
                if ($sql_del_details['delivery'] == 1 || $sql_del_details['pickup'] == 1) {
                    $redirect_url = 'https://foodandmenu.com/restaurant.php?id=' . $_REQUEST['id'] . '&type=del';
                    echo '<script type="text/javascript">window.location.href="' . $redirect_url . '";</script>';
                    exit;
                } else {
                    $error_msg1 = 4;
                }
            } else {
                $redirect_url = 'https://foodandmenu.com/restaurant.php?id=' . $_REQUEST['id'] . '&type=del';
                echo '<script type="text/javascript">window.location.href="' . $redirect_url . '";</script>';
                exit;
            }
        } else {
            $error_msg1 = 3;
        }
    }
    header("location:restaurant.php?id=" . $_REQUEST['id'] . "&error_msg=$error_msg1");
}


if ($_REQUEST['submit'] == 'VERIFY ADDRESS') {
    unset($_SESSION['del_charge' . $ses_rest_id]);

    $i = $_REQUEST['menu_id'];
    $address = $_REQUEST['address'];
    /* if($address!=''){
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
      }

      $user_add_lat = $latlng->lat;
      $user_add_long = $latlng->lng; */

    /* 	$user_add_lat = 11;
      $user_add_long = 11; */



    $array_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $_REQUEST['id'] . "'"));

    $rest_address = $array_basic_info['restaurant_address'] . "," . $array_basic_info['restaurant_city'] . "," . $array_basic_info['restaurant_state'] . "," . $array_basic_info['restaurant_zip'] . "," . $array_basic_info['restaurant_country'];

    /* $rest_add_lat = $array_basic_info['latitude'];
      $rest_add_lng = $array_basic_info['longitude'];


      $distance_in_miles = distance($user_add_lat, $user_add_long, $rest_add_lat, $rest_add_lng, "M");
      $distance = round($distance_in_miles,2); */

    //echo $distance; exit;
    //$distance = 8.55;
    //$distance_in_miles1 = distance(30.3637821,-97.6837399,30.145158,-97.85092, "M");
    //echo $distance_in_miles1; exit;


    $start = str_replace(' ', '+', $rest_address);
    $finish = str_replace(' ', '+', $address);

    $url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $start . '&destinations=' . $finish . '&mode=driving&language=en&sensor=false';
    $data = file_get_contents($url);
    $data = utf8_decode($data);
    $obj = json_decode($data);

    $distance = 0.621371 * ($obj->rows[0]->elements[0]->distance->text);

    //echo $distance; exit;

    $rest_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '" . $_REQUEST['id'] . "'"));

    if ($distance == 0) {
        $error_msg1 = 1;
    } else {
        $sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $_REQUEST['id'] . "' ORDER BY delivery_range");
        while ($array_del_charge = mysql_fetch_array($sql_del_crge)) {
            if ($distance <= $array_del_charge['delivery_range']) {
                $_SESSION['del_charge' . $ses_rest_id] = $array_del_charge['delivery_charge'];
                break;
            }
        }

        //echo $distance."<br>".$_SESSION['del_charge'.$ses_rest_id]; exit;

        $sql_del_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $_REQUEST['id'] . "' ORDER BY delivery_range DESC LIMIT 0,1"));

        if ($distance <= $sql_del_charge['delivery_range']) {
            if ($_SESSION['customer_id'] != '') {
                if ($sql_del_details['delivery'] == 1 || $sql_del_details['pickup'] == 1) {
                    //header("location:check_out.php?type=del");
                    $redirect_url = 'https://foodandmenu.com/restaurant.php?id=' . $_REQUEST['id'] . '&type=del';
                    echo '<script type="text/javascript">window.location.href="' . $redirect_url . '";</script>';
                    exit;
                } else {
                    $error_msg1 = 4;
                }
            } else {
                //$redirect_url = 'http://foodandmenu.com/login.php?type=del';
                $redirect_url = 'https://foodandmenu.com/restaurant.php?id=' . $_REQUEST['id'] . '&type=del';
                echo '<script type="text/javascript">window.location.href="' . $redirect_url . '";</script>';
                //header("location:http://foodandmenu.com/login.php?type=del");
                exit;
            }
        } else {
            $error_msg1 = 3;
        }
    }
    header("location:restaurant.php?id=" . $_REQUEST['id'] . "&error_msg=$error_msg1");
}

if ($_REQUEST['add'] == 'ADD ITEM') {
    $i = $_REQUEST['menu_id'];
    $sql_spcl_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '" . $i . "'");
    $spl_price = 0;
    $sep = '';
    $spl_ins = '';
    while ($array_spcl_ins = mysql_fetch_array($sql_spcl_ins)) {
        $spl_ins = $spl_ins;
        if ($_REQUEST['radio' . $i . '_' . $array_spcl_ins['id']] != '') {
            $spl_ins.= $sep . $_REQUEST['radio' . $i . '_' . $array_spcl_ins['id']];
        }
        $sep = ',';
        $sql_spl_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '" . $_REQUEST['radio' . $i . '_' . $array_spcl_ins['id']] . "'"));
        $spl_price = $sql_spl_price['price'] + $spl_price;
    }
    //echo $spl_ins; exit;

    $total_price = $spl_price + $_REQUEST['menu_price' . $i];

    $sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '" . $session_id . "' AND menu_item_id = '" . $_REQUEST['menu_id'] . "'");
    $num_rows = mysql_num_rows($sql_select_cart_items);
    //if($num_rows == 0){
    $tax = ($sql_del_details['tax'] / 100 * $total_price);
    $sql_insert_into_cart = "INSERT INTO restaurant_menuitem_cart SET menu_item_id = '" . $_REQUEST['menu_id'] . "',session_id = '" . $session_id . "',restaurant_id = '" . $_REQUEST['restaurant_id' . $i] . "',quantity = '" . $_REQUEST['quantity' . $i] . "',special_ins = '" . htmlspecialchars(stripslashes($_REQUEST['special_instructions' . $i]), ENT_QUOTES) . "' , menu_price = '" . $_REQUEST['menu_price' . $i] . "' , price = '" . $total_price . "' , additional_instructions = '" . htmlspecialchars(stripslashes($spl_ins), ENT_QUOTES) . "',tax = '" . $tax . "' , group_id = '" . $_SESSION['group_order_id' . $ses_rest_id] . "' , group_order_details_id = '" . $_SESSION['group_order_details_id' . $ses_rest_id] . "' ";

    mysql_query($sql_insert_into_cart);


    $sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '" . $session_id . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
    $num_rows = mysql_num_rows($sql_select_cart_items);

    $cart_amt = 0;
    while ($array_cart_items = mysql_fetch_array($sql_select_cart_items)) {
        $cart_amt = $cart_amt + ($array_cart_items['price'] * $array_cart_items['quantity']);
    }

    if ($_SESSION['coupon_code' . $ses_rest_id] != '') {
        if ($num_rows > 0) {
            $sql_sel_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '" . $_SESSION['coupon_code' . $ses_rest_id] . "' AND restaurant_id = '" . $_REQUEST['id'] . "'"));


            if ($sql_sel_coupon['minimum_order_amount'] < $cart_amt) {
                if ($sql_sel_coupon['discount'] != 0.00) {
                    $_SESSION['coupon_discount' . $ses_rest_id] = number_format(($sql_sel_coupon['discount'] * $cart_amt) / 100, 2);
                } else {
                    $_SESSION['coupon_discount' . $ses_rest_id] = number_format($sql_sel_coupon['coupon_price'], 2);
                }
            } else {
                $_SESSION['coupon_discount' . $ses_rest_id] = '';
                $_SESSION['coupon_code' . $ses_rest_id] = '';
            }
        } else {
            $_SESSION['coupon_discount' . $ses_rest_id] = '';
            $_SESSION['coupon_code' . $ses_rest_id] = '';
        }

        //echo $_SESSION['coupon_discount'.$ses_rest_id]; exit;
    }


    if ($_SESSION['reward_point' . $ses_rest_id] != '') {
        if ($num_rows > 0) {
            $_SESSION['reward_point' . $ses_rest_id] = number_format(($cart_amt * $_SESSION['user_reward_point' . $ses_rest_id]) / 100, 2);
        }
    } else {
        $_SESSION['reward_point' . $ses_rest_id] = '';
        $_SESSION['user_reward_point' . $ses_rest_id] = '';
    }


    //$error_msg1 = 2;
    header("location:restaurant.php?id=" . $_REQUEST['id'] . "&error_msg=" . $error_msg1 . "");
}

if ($_REQUEST['submit'] == "Start Your Order") {
    $share_link = $_REQUEST['share_link'];
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email_adm'];
    $restaurant_id = $_REQUEST['id'];

    $ins = mysql_query("INSERT INTO restaurant_group_order SET restaurant_id = '" . $restaurant_id . "', share_link = '" . $share_link . "', post_date = NOW()");
    $last_id = mysql_insert_id();
    $ins_detail = mysql_query("INSERT INTO restaurant_group_order_details SET group_order_id = '" . $last_id . "', name = '" . $name . "', email_id = '" . $email . "', is_admin = '1' ");

    $last_id_details = mysql_insert_id();

    $_SESSION['group_order_details_id' . $ses_rest_id] = $last_id_details;
    $_SESSION['group_order_id' . $ses_rest_id] = $last_id;

    header("location:" . $share_link . "");
}

if ($_REQUEST['submit'] == "Start") {
    $ins_detail = mysql_query("INSERT INTO restaurant_group_order_details SET group_order_id = '" . $_REQUEST['group_order_id_hid'] . "', name = '" . $_REQUEST['chld_name'] . "', email_id = '" . $_REQUEST['email_top'] . "', is_admin = '0' ");
    $last_id = mysql_insert_id();

    $_SESSION['group_order_details_id' . $ses_rest_id] = $last_id;
    $_SESSION['group_order_id' . $ses_rest_id] = $_REQUEST['group_order_id_hid'];

    header("location:" . $_REQUEST['share_link_hid'] . "");
}

if ($_REQUEST['session_group'] != "") {
    $delete = mysql_query("DELETE FROM restaurant_group_order_details WHERE id = '" . $_SESSION['group_order_details_id' . $ses_rest_id] . "'");
    if ($delete) {
        mysql_query("DELETE FROM restaurant_menuitem_cart WHERE group_order_details_id = '" . $_SESSION['group_order_details_id' . $ses_rest_id] . "'");

        $_SESSION['group_order_details_id' . $ses_rest_id] = "";
        $_SESSION['group_order_id' . $ses_rest_id] = "";
    }

    header("location:restaurant.php?id=" . $_REQUEST['res_id'] . "");
}
?>
<style type="text/css">
    #fade11 {
        width: 100%;
        height: 800px;
        position: fixed;
        z-index: 50;
        background: rgb(223, 105, 0);
        opacity: 0.5;
    }
    .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    #address {
        background-color: #fff;
        padding: 0 11px 0 13px;
        width: 400px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        text-overflow: ellipsis;
    }
    #address:focus {
        border-color: #4d90fe;
        margin-left: -1px;
        padding-left: 14px;  /* Regular padding-left + 1. */
        width: 401px;
    }
    .pac-container {
        font-family: Roboto;
        z-index: 9999999999999999999999999999999999 !important;
        font-family: Calibri !important;
        font-size: 14px !important;
    }
    #map-canvas {
        display: none;
    }
</style>
<script type="text/javascript">
    function getkey(e)
    {
        if (window.event)
            return window.event.keyCode;
        else if (e)
            return e.which;
        else
            return null;
    }
    function goodchars(e, goods)
    {
        var key, keychar;
        key = getkey(e);
        if (key == null)
            return true;
        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();
        goods = goods.toLowerCase();
        if (goods.indexOf(keychar) != -1)
            return true;
        if (key == null || key == 0 || key == 8 || key == 9 || key == 13 || key == 27)
            return true;
        return false;
    }
</script>

<body onLoad="init();">
    <?php
    if ($_REQUEST['error_msg'] != '') {
        $display = 'block';
    } else {
        $display = 'none';
    }
    ?>
    <div id="fade11" style="display:<?php echo $display; ?>"></div>
    <div style="width:400px; height:1px; margin:0 auto; display:<?php echo $display; ?>" id="light">
        <div  style="width:300px; position:absolute; z-index:9999999; background:#fff; padding:50px 20px; color:#000; font-family:Calibri; font-size:18px; height:100px; -moz-box-shadow: 0 0 5px #888;-webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888; text-align:center; margin-top:200px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border:#2C4598 2px solid;">
            <?php
            if (($_REQUEST['error_msg'] == 1) || ($_REQUEST['error_msg'] == 3) || ($_REQUEST['error_msg'] == 4)) {
                $style = 'margin-left: 293px; position: absolute; margin-top: -60px; cursor:pointer;';
            } else if ($_REQUEST['error_msg'] == 2) {
                $style = 'margin-left: 272px; position: absolute; margin-top: -60px; cursor:pointer;';
            } else if ($_REQUEST['error_msg'] == 5) {
                $style = 'margin-left: 247px; position: absolute; margin-top: -60px; cursor:pointer;';
            } else if ($_REQUEST['error_msg'] == 6) {
                $style = 'margin-left: 305px; position: absolute; margin-top: -60px; cursor:pointer;';
            } else if ($_REQUEST['error_msg'] == 7) {
                $style = 'margin-left: 265px; position: absolute; margin-top: -60px; cursor:pointer;';
            } else if ($_REQUEST['error_msg'] == 8) {
                $style = 'margin-left: 299px; position: absolute; margin-top: -60px; cursor:pointer;';
            } else if ($_REQUEST['error_msg'] == 9) {
                $style = 'margin-left: 299px; position: absolute; margin-top: -60px; cursor:pointer;';
            }
            ?>
            <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display = 'none';
                    document.getElementById('fade11').style.display = 'none';
                    document.getElementById('fade').style.display = 'none'"><img src="images/fancy_closebox.png" style="<?php echo $style; ?>"/></a>
            <?php
            if ($_REQUEST['error_msg'] == 1) {
                echo "We cannot locate you.Please be more specific.";
            } else if ($_REQUEST['error_msg'] == 2) {
                echo "Items successfully added to cart";
            } else if ($_REQUEST['error_msg'] == 3) {
                echo "Your address is not within our delivery range";
            } else if ($_REQUEST['error_msg'] == 4) {
                echo "This restaurant does not give pickup or delivery";
            } else if ($_REQUEST['error_msg'] == 5) {
                echo "Item deleted successfully";
            } else if ($_REQUEST['error_msg'] == 6) {
                echo "Your Request has been sent Successfully.";
            } else if ($_REQUEST['error_msg'] == 7) {
                echo "Reservation Sent Successfully.";
            } else if ($_REQUEST['error_msg'] == 8) {
                echo "Minimum order amount for this coupon has not reached. Please add more items to your cart.";
            } else if ($_REQUEST['error_msg'] == 9) {
                echo "Order Confirmed Successfully.";
            }
            ?>
        </div>
    </div>
    <style>
        #login-poup-area{width:620px; background-color:#EFEFEF; position:fixed; z-index:99999900; top:60px; height:420px; border-radius:7px;}.newpopup h3{color:#fff;padding:15px 0; background-color:#060606; text-align:center; width:100%; border-radius:7px 7px 0 0; font-size:18px;}.newpopup p{color:#000; font:bold 13px/26px 'droid_sansregular';padding-left:10px; margin:5px 10px;}.login_cross_bt{width:21px;height: 21px;position:absolute;margin: 4px 0px 0px 688px;z-index: 90000;}.popcontent label{ color:#a2a2a2; width:100%; float:left;}.popcontent input[type=text], .popcontent input[type=password]{height:26px; line-height:26px; font:normal 12px 'droid_sansregular'; color:#ddd; background-color:#333; width:94%;}#sidetab{display:none; width:620px; margin:0 auto; height:1px;}#fade{ background:#000000; opacity:0.6; filter:alpha(opacity=60); z-index:99; height:800px; width:100%; position:fixed; display:none;}.popcontent a{color:#060606; text-decoration:underline; font:normal 12px 'droid_sansregular'; float:right; margin-top:6px; margin-right:20px;}.popcontent a:hover{color:#FF7200; text-decoration:none;}.popcontent input[type=submit]{cursor:pointer;background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(69,69,69)));border-radius:3px;border:1px solid #0a0a0a;color: #005A61;width:92px;display: block;text-decoration: none;color:#fff;text-shadow: 0px 0px white, 0px 0px #444; font:normal 15px 'open_sansregular'; float:left; margin-bottom:20px; margin-top:10px; padding:4px 0 5px;}.popcontent input[type=submit]:hover{background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(51,50,51)));}
    </style>
    <style type="text/css">
        #fade
        {
            position:fixed;
            height:900px;
            z-index:999;
            background:#df6900;
            opacity:0.5;
            display:none;
        }


        .pop_item{position: absolute;margin:-550px -180px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;
                  width:900px;}
        .pop_item1{position: absolute;margin:0px 105px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999; width:900px;}
        .pop_item2{position: absolute;margin:-900px 0px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999; width:600px;}
        .reviews_pop{position: absolute;background:#f5f5f5; box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; margin-top:-550px !important; z-index:99999999;}
        .reviews_pop h2 img{ float:right;}
        .pop_item h2 img{ float:right;}
        .pop_item .pop_commnt {
            width:399px !important;
            float:left;
        }
    </style>
    <script language="javascript">
        function showsidetab()
        {
            document.getElementById('fade').style.display = "block";
            document.getElementById('local_review').style.display = "block";
        }
        function closesidetab()
        {
            document.getElementById('fade').style.display = "none";
            document.getElementById('local_review').style.display = "none";
        }

        function popularitem()
        {
            document.getElementById('fade').style.display = "block";
            document.getElementById('popular_item').style.display = "block";
        }
        function closepopularitem()
        {
            document.getElementById('fade').style.display = "none";
            document.getElementById('popular_item').style.display = "none";
        }
        function add_item(id)
        {
            document.getElementById('fade').style.display = "block";
            document.getElementById('add_item' + id).style.display = "block";
        }
        function closeadditem(id)
        {
            document.getElementById('fade').style.display = "none";
            document.getElementById('add_item' + id).style.display = "none";
        }
        /*function check_menu_size(id){
         document.getElementById('add_item_btn'+id).style.display = 'block';
         document.getElementById('add_item_img'+id).style.display = 'none';
         }*/
        function del_block() {
            document.getElementById('fade').style.display = "block";
            document.getElementById('del_add').style.display = "block";
        }
        function closedel_add()
        {
            document.getElementById('fade').style.display = "none";
            document.getElementById('del_add').style.display = "none";
        }
        function check_validation(id) {
            if (document.getElementById('submit').value == 'VERIFY ADDRESS') {
                if (document.getElementById('address' + id).value == '') {
                    alert('Please enter a valid street address.');
                    document.getElementById('address' + id).focus();
                    return false;
                }
            }
            return true;
        }
    </script> 
    <script type="text/javascript">
        function show_map() {
            if (document.getElementById('map_div').style.display == 'none') {
                document.getElementById('map_div').style.display = 'block';
                document.getElementById('hide_map').style.display = 'block';
                document.getElementById('show_map').style.display = 'none';
            }
            else if (document.getElementById('map_div').style.display == 'block') {
                document.getElementById('map_div').style.display = 'none';
                document.getElementById('hide_map').style.display = 'none';
                document.getElementById('show_map').style.display = 'block';
            }
        }
    </script> 
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        function open_single_slider_div(id)
        {
            $j("#slider_div" + id).css('visibility', 'visible');
            $j(".flexslider .slides > li").show();
            $j(".flexslider .slides > li").width('546');
            //$j(".flexslider .slides > li").css( { marginLeft : "30px" } );
            $j('.flexslider .slides > li').css('margin-left', "30px");
            $j("#slider_div" + id).css('opacity', '1');
            $j("#fade1").show();
        }

        function close_single_slider_div(id)
        {
            $j("#slider_div" + id).css('visibility', 'hidden');
            $j("#slider_div" + id).css('opacity', '0');
            $j("#fade1").hide();
        }

        function open_menu_div()
        {
            $j("#sidebox").show();
        }
        function close_menu_div()
        {
            $j("#sidebox").hide();
        }

        function open_desired_div(id)
        {
			var $j = jQuery.noConflict();
            //$j('.accordion_content').slideUp();
            //$j('.accordion_toggle').removeClass('accordion_toggle_active');
            $j('#accor_subcat' + id).addClass('accordion_toggle_active');
            $j('#div_subcat_content'+id).css({'display':'block','height':'auto'});
            //$j('html, body').animate({scrollTop: $j('#div_accor_subcat' + id).offset().top}, '100');
            $j('html, body').animate({scrollTop: $j('#accor_subcat' + id).offset().top}, '100');
        }
    </script>
    <div id="fade"></div>
    <div id="top_div"></div>
<?php //include ("includes/top_search.php"); ?>
<?php //include ("includes/menu_section.php"); ?>
<?php include ("includes/header_inner_new.php"); ?>
    <div class="body_section">
        <div class="container">
            <div class="body_top"></div>
            <div class="main_body">
                <div class="food_body_cont">
                    <div class="food_content">
<?php include("includes/restaurant_top.php"); ?>
                        <script type="text/javascript">
                            jQuery(function () {
                                var YouTubeRegex = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
                                jQuery('a.video').each(function (i) {
                                    jQuery(this).click(function (event) {
                                        event.preventDefault();
                                        var videoID = jQuery(this).attr('href').match(YouTubeRegex);
                                        //alert(videoID[1]);
                                        jQuery('div#fade').show();
                                        jQuery('div#video_content').css({
                                            padding: '10px',
                                        }).html('<span style="float: left;font-size: 20px;margin-left: 240px;margin-top: 190px;">Loading Video</span>');
                                        jQuery('div#sidetab').show();
                                        setTimeout(function () {
                                            jQuery('div#video_content').html('<iframe width="600" height="400" src="//www.youtube.com/embed/' + videoID[1] + '?wmode=transparent&autoplay=1" frameborder="0" allowfullscreen></iframe>');
                                        }, 5000);
                                    });
                                });
                                jQuery('a#video_close').click(function (event) {
                                    event.preventDefault();
                                    jQuery('div#sidetab').hide();
                                    jQuery('div#fade').hide();
                                    jQuery('div#video_content').html('').removeAttr('style');
                                });
                            });</script>
                            <script type="text/javascript">
								var $j = jQuery.noConflict();
								$j(document).ready(function () {

									var element = $j('.follow-scroll'),
											originalY = element.offset().top;
									// Space between element and top of screen (when scrolling)
									var topMargin = 180;
									// Should probably be set in CSS; but here just for emphasis
									element.css('position', 'relative');
									$j(window).on('scroll', function (event) {
										var scrollTop = $j(window).scrollTop();
										element.stop(false, false).animate({
											top: scrollTop < originalY
													? 0
													: scrollTop - originalY + topMargin
										}, 300);
									});
								});
								
                                
                                </script>
                        <div class="accr_menu" id="tab">
<?php include('includes/tab_menu.php'); ?>
                        </div>
                        <!--<div class="clear"></div>-->
                        <div class="accr_details" >
                        	<div class="follow-scroll">
                            <div ua-label=" " ua-action="Menu Sections" id="sidemenu" style="margin-top: 0px;" onClick="open_menu_div();">
                                <div>Menu Sections</div>
                            </div>
                            <div id="sidebox">
                                <?php
                                $menu_category1 = "SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (" . $_REQUEST['id'] . ") ";
                                $menu_category1.= " ORDER BY show_order ";
                                $sql_menu_category1 = mysql_query($menu_category1);
                                $inc = 1;
                                while ($array_menu_catyegory1 = mysql_fetch_array($sql_menu_category1)) {
                                    if ($_REQUEST['c_id'] == $array_menu_catyegory1['id']) {
                                        $display_sta = 'block';
                                    } else {
                                        $display_sta = 'none';
                                    }
                                    ?>
                                    <ul class="side_menus">
    <?php if ($inc == 1) { ?>
                                            <a class="m-close" style="cursor: pointer; padding: 6px; float: right;" onClick="close_menu_div();"> <img width="14" border="0" height="14" title="Close Menu" alt="Close Menu" src="images/cross.png"> </a>
    <?php } ?>
                                        <li><a href="javascript:void(0);" id="cat_a_sidebox<?php echo $array_menu_catyegory1['id']; ?>" class="cat_a_sidebox" onClick="open_accor('<?php echo $array_menu_catyegory1['id']; ?>');"><i class="fa fa-plus"></i></a><a title="<?php echo $array_menu_catyegory1['category_name']; ?>" href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&c_id=<?php echo $array_menu_catyegory1['id']; ?>#tab"><?php echo $array_menu_catyegory1['category_name']; ?></a>
                                        <ul class="sub_cat_sidebox" id="sub_cat_sidebox<?php echo $array_menu_catyegory1['id'];?>" style="display:none;">
                                       <?php
									   $sql_sub_category1 = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND category_id = '" . $array_menu_catyegory1['id'] . "' ORDER BY show_order ");
									   while ($array_menu_subcatyegory1 = mysql_fetch_array($sql_sub_category1)) {
									   ?>
                                        <li><a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&c_id=<?php echo $array_menu_catyegory1['id']; ?>&sbcat_id=<?php echo $array_menu_subcatyegory1['id']; ?>#tab"><i class="fa fa-level-up"></i> <?php echo $array_menu_subcatyegory1['subcategory_name']; ?></a></li>
                                        <?php } ?>
                                        </ul>
                                        </li>
                                    </ul>
                                    <div class="clear"></div>
                                    <div>
                                        <div class="side_sections" style="margin: 0px; overflow: hidden; display:<?php echo $display_sta; ?>;">
                                            <ul>
                                                <?php
                                                $sql_menu_subcategory1 = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE category_id = '" . $array_menu_catyegory1['id'] . "' AND restaurant_id = '" . $_REQUEST['id'] . "' ORDER BY show_order ");
                                                while ($array_menu_sub_category1 = mysql_fetch_array($sql_menu_subcategory1)) {
                                                    if ($array_menu_sub_category1['subcategory_name'] != '') {
                                                        ?>
                                                <li><a ua-action="Menu Sections"  title="<?php echo $array_menu_sub_category1['subcategory_name']; ?>" href="javascript:void(0);" onClick="open_desired_div('<?php echo $array_menu_sub_category1['id']; ?>');"  ><?php echo $array_menu_sub_category1['subcategory_name']; ?> </a></li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                    $inc++;
                                }
                                ?>
                            </div>
                            </div>
                            <?php /* ?><div id="sidebox">
                              <ul class="side_menus">
                              <a class="m-close" style="cursor: pointer; padding: 6px; float: right;" onClick="close_menu_div();">
                              <img width="14" border="0" height="14" title="Close Menu" alt="Close Menu" src="images/cross.png">
                              </a>
                              <?php
                              $menu_category1 = "SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (" . $_REQUEST['id'] . ") ";

                              $menu_category1.= " ORDER BY show_order ";

                              $sql_menu_category1 = mysql_query($menu_category1);
                              while ($array_menu_catyegory1 = mysql_fetch_array($sql_menu_category1)) { ?>
                              <li><a title="Full Menu" href="javascript:void(0)"><?php echo $array_menu_catyegory1['category_name'];?></a></li>
                              <?php } ?>
                              </ul>
                              <div class="clear"></div>
                              <div>
                              <div class="side_sections" style="margin: 0px; overflow: hidden;" style="display:none;">
                              <ul>

                              <li><a ua-action="Menu Sections"  title="Entree" href="javascript:void(0)"></a><?php //echo $sub_cat1['sub_category']; ?></li>

                              </ul>
                              </div>

                              </div>
                              </div><?php */ ?>
                            <?php /* ?><div class="menu_nav">
                              <ul>
                              <li><a href="restaurant.php?id=<?php echo $_REQUEST['id'];?>#tab"  <?php if($_REQUEST['c_id']==''){ ?> class="active6" <?php } ?>>All Available Items</a></li>
                              <?php $sql_menu_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE id!=''");
                              while($array_menu_catyegory = mysql_fetch_array($sql_menu_category)){?>
                              <li><a href="restaurant.php?id=<?php echo $_REQUEST['id'];?>&c_id=<?php echo $array_menu_catyegory['id'];?>#tab" <?php if($array_menu_catyegory['id'] == $_REQUEST['c_id']){ ?> class="active6" <?php }?>><?php echo $array_menu_catyegory['category_name'];?></a></li>
                              <?php } ?>

                              </ul>

                              </div><?php */ ?>
                            <div class ="menu_nav menu_modified">
                                <ul>
                                    <li><a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>#tab"  <?php if ($_REQUEST['c_id'] == '') { ?> class="active6" <?php } ?>>All Available Items <span class="brdr_lft_r8"></span><i class="arrow-d"></i> </a></li>
                                    <?php
                                    //$sql_menu_category = mysql_query("SELECT DISTINCT(category_id),category_name FROM restaurant_menu_item WHERE restaurant_id = '".$_REQUEST['id']."'");

                                    $sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $_REQUEST['id'] . "'"));
                                    $address = $sql_select_add['restaurant_address'] . " " . $sql_select_add['restaurant_city'] . " " . $sql_select_add['restaurant_state'] . " " . $sql_select_add['restaurant_zipcode'];

                                    $timezone = getTimezone($address);

                                    if ($timezone != '') {
                                        date_default_timezone_set($timezone);
                                    } else {
                                        date_default_timezone_set('America/Chicago');
                                    }

                                    $current_time = date('h:i A');

                                    $menu_category = "SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (" . $_REQUEST['id'] . ") ";

                                    $menu_category.= " ORDER BY show_order ";

                                    $sql_menu_category = mysql_query($menu_category);
                                    while ($array_menu_catyegory = mysql_fetch_array($sql_menu_category)) {
                                        $today = date('l');
                                        $day = strtolower($today);

                                        $time_from = $array_menu_catyegory['category_' . $day . '_from'];
                                        $time_to = $array_menu_catyegory['category_' . $day . '_to'];

                                        $current_time1 = DateTime::createFromFormat('H:i A', $current_time);
                                        $time1 = DateTime::createFromFormat('H:i A', $time_from);
                                        $time2 = DateTime::createFromFormat('H:i A', $time_to);

                                        if (($current_time1 > $time1 && $current_time1 < $time2) || ($time_from == '' && $time_to == '')) {
                                            ?>
                                            <li><a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&c_id=<?php echo $array_menu_catyegory['id']; ?>#tab" <?php if ($array_menu_catyegory['id'] == $_REQUEST['c_id']) { ?> class="active6" <?php } ?>><?php echo $array_menu_catyegory['category_name']; ?> <span class="brdr_lft_r8"></span><i class="arrow-d"></i></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <div class="clear"></div>
                            </div>
                            <form id="type_search" name="type_search" method="post" action="" enctype="multipart/form-data">
                                <div id="legend_flt" class="f_clear">
                                    <div class="flt" title="What's Good">
                                        <input id="whats_good" name="whats_good" type="checkbox" class="legend_icons_top checkbox" value="tag_good" <?php if ($_REQUEST['whats_good'] != "") { ?> checked <?php } ?> >
                                        <label for="whats_good" title="What's Good" class="labelFull">WHAT'S GOOD</label>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="flt" title="Spicy">
                                        <input id="spicy" name="spicy" type="checkbox" class="legend_icons_top checkbox" value="tag_spicy" <?php if ($_REQUEST['spicy'] != "") { ?> checked <?php } ?> >
                                        <label for="spicy" title="Spicy" class="labelFull">SPICY</label>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="flt" title="Vegetarian">
                                        <input id="veggie" name="veggie" type="checkbox" class="legend_icons_top checkbox" value="tag_veggie" <?php if ($_REQUEST['veggie'] != "") { ?> checked <?php } ?> >
                                        <label for="veggie" title="Vegetarian" class="labelFull">VEGGIE</label>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="flt" title="Healthy">
                                        <input id="healthy" name="healthy" type="checkbox" class="legend_icons_top checkbox" value="tag_healthy" <?php if ($_REQUEST['healthy'] != "") { ?> checked <?php } ?> >
                                        <label for="healthy" title="Healthy" class="labelNull">HEALTHY</label>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </form>
                            <div class="clear"></div>
                            <script type="text/javascript">
                                var $j = jQuery.noConflict();
                                $j(function () {
                                    $j('.checkbox').on('change', function () {
                                        $j('#type_search').submit();
                                    });
                                });</script>
                            <div id="vertical_container" class="rstrnt_panel" style="min-height:1000px; border:none !important;">
                                <?php
                                $all_menu_id = "";
                                $menu_sep = "";
                                $res_restaurant_main_category = mysql_query("select sub_category_id from restaurant_menu_item where restaurant_id='" . $_REQUEST['id'] . "'");
                                while ($select_restaurant_main_category = mysql_fetch_array($res_restaurant_main_category)) {
                                    $all_menu_id.=$menu_sep . $select_restaurant_main_category['sub_category_id'];
                                    $menu_sep = ",";
                                }
                                ?>
                                <?php /* ?><?php
                                  $all_menu_id="";
                                  $menu_sep="";
                                  $res_restaurant_main_category=mysql_query("select * from sub_category_name where restaurant_id='".$_REQUEST['id']."'");
                                  while($select_restaurant_main_category=mysql_fetch_array($res_restaurant_main_category))
                                  {
                                  $all_menu_id.=$menu_sep.$select_restaurant_main_category['sub_category_id'];
                                  $menu_sep=",";
                                  }
                                  ?><?php */ ?>
                                <?php
                                /* $sql_sub_category =("SELECT * FROM restaurant_menu_subcategory WHERE id IN(".$all_menu_id.")");
                                  if($_REQUEST['c_id']){
                                  $sql_sub_category.= " AND category_name = '".$_REQUEST['c_id']."'";
                                  }
                                  $sql_sub_category.= "ORDER BY show_order";
                                  $sql_query = mysql_query($sql_sub_category); */

                                /* $sql_sub_category = "SELECT DISTINCT(sub_category_id) FROM  restaurant_menu_item WHERE restaurant_id = '".$_REQUEST['id']."'";
                                  if($_REQUEST['c_id']){
                                  $sql_sub_category.= " AND category_id = '".$_REQUEST['c_id']."'";
                                  }
                                  $sql_sub_category.= "ORDER BY category_name";

                                  echo $sql_sub_category; */

                                /* $sql_sub_category =("SELECT * FROM restaurant_menu_subcategory WHERE id IN(".$all_menu_id.")");
                                  if($_REQUEST['c_id']){
                                  $sql_sub_category.= " AND category_id = '".$_REQUEST['c_id']."'";
                                  }
                                  $sql_sub_category.= "ORDER BY show_order"; */

                                $sql_sub_category = "SELECT * FROM restaurant_menu_subcategory WHERE restaurant_id = '" . $_REQUEST['id'] . "' ";

                                if ($_REQUEST['c_id'] != '') {
                                    $sql_sub_category.= " AND category_id = '" . $_REQUEST['c_id'] . "' ";
                                }

                                $sql_sub_category.= " ORDER BY show_order ";


                                //echo $sql_sub_category;						

                                $sql_query = mysql_query($sql_sub_category);

                                $sql_mn11 = "SELECT * FROM restaurant_menu_item WHERE restaurant_id = '" . $_REQUEST['id'] . "' ";

                                if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR spicy = 1 OR veggie = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR spicy = 1 OR veggie = 1 )";
                                } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR spicy = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR veggie = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( spicy = 1 OR veggie = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR spicy = 1 )";
                                } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['veggie'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR veggie = 1 )";
                                } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "") {
                                    $sql_mn11.= " AND ( spicy = 1 OR veggie = 1 )";
                                } else if ($_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( veggie = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['spicy'] != "" && $_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( spicy = 1 OR healthy = 1 )";
                                } else if ($_REQUEST['whats_good'] != "") {
                                    $sql_mn11.= " AND ( whats_good = 1 )";
                                } else if ($_REQUEST['spicy'] != "") {
                                    $sql_mn11.= " AND ( spicy = 1 )";
                                } else if ($_REQUEST['veggie'] != "") {
                                    $sql_mn11.= " AND ( veggie = 1 )";
                                } else if ($_REQUEST['healthy'] != "") {
                                    $sql_mn11.= " AND ( healthy = 1 )";
                                }

                                //echo $sql_mn11;
                                $sql_mn_query = mysql_query($sql_mn11);
                                $sub_catid = '';
                                $sep = '';
                                while ($arr_sub_cat = mysql_fetch_array($sql_mn_query)) {
                                    $sub_catid = $sub_catid . $sep . $arr_sub_cat['sub_category_id'];
                                    $sep = ',';
                                }

                                $array_subcategory_id = explode(",", $sub_catid);


                                if (mysql_num_rows($sql_query) > 0) {
                                    while ($array_sub_category = mysql_fetch_array($sql_query)) {

                                        $time_from1 = $array_sub_category['sub_category_' . $day . '_from'];
                                        $time_to1 = $array_sub_category['sub_category_' . $day . '_to'];

                                        $current_time1 = DateTime::createFromFormat('H:i A', $current_time);
                                        $time11 = DateTime::createFromFormat('H:i A', $time_from1);
                                        $time22 = DateTime::createFromFormat('H:i A', $time_to1);

                                        if (($current_time1 > $time11 && $current_time1 < $time22) || ($time_from1 == '' && $time_to1 == '')) {

                                            if (in_array($array_sub_category['id'], $array_subcategory_id)) {
                                                ?>
                                                
                                                <h1 id="accor_subcat<?php echo $array_sub_category['id']; ?>" class="accordion_toggle" style="border:1px solid #ffc198;"><?php echo $array_sub_category['subcategory_name']; ?></h1>
                                                <div id="div_subcat_content<?php echo $array_sub_category['id']; ?>" class="accordion_content" style="border:1px solid #ffc198;">
                                                    <?php $sql_subcat = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND sub_category_id = '" . $array_sub_category['id'] . "' AND sub_category_description!=''")); ?>
                                                    <?php
                                                    $sql_mn = "SELECT * FROM restaurant_menu_item WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND sub_category_id = '" . $array_sub_category['id'] . "' ";


                                                    if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR spicy = 1 OR veggie = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR spicy = 1 OR veggie = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR spicy = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR veggie = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( spicy = 1 OR veggie = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['spicy'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR spicy = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['veggie'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR veggie = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['spicy'] != "" && $_REQUEST['veggie'] != "") {
                                                        $sql_mn.= " AND ( spicy = 1 OR veggie = 1 )";
                                                    } else if ($_REQUEST['veggie'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( veggie = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['spicy'] != "" && $_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( spicy = 1 OR healthy = 1 )";
                                                    } else if ($_REQUEST['whats_good'] != "") {
                                                        $sql_mn.= " AND ( whats_good = 1 )";
                                                    } else if ($_REQUEST['spicy'] != "") {
                                                        $sql_mn.= " AND ( spicy = 1 )";
                                                    } else if ($_REQUEST['veggie'] != "") {
                                                        $sql_mn.= " AND ( veggie = 1 )";
                                                    } else if ($_REQUEST['healthy'] != "") {
                                                        $sql_mn.= " AND ( healthy = 1 )";
                                                    }



                                                    $sql_mn.= " ORDER BY show_order ";

                                                    //echo $sql_mn;

                                                    $sql_menu = mysql_query($sql_mn);
                                                    if (mysql_num_rows($sql_menu) > 0) {
                                                        ?>
                                                        <?php if ($sql_subcat['sub_category_description'] != "") { ?>
                                                            <p><?php echo $sql_subcat['sub_category_description'] ?></p>
                                                        <?php } ?>
                                                        <?php
                                                        $cnt = 1;
                                                        while ($array_menu = mysql_fetch_array($sql_menu)) {
                                                            ?>
                        <?php /* ?><?php echo '<pre>';
                          print_r($array_menu);exit; ?><?php */ ?>
                                                            <div class="pop_item pop_item_nw" style="display:none;" id="add_item<?php echo $array_menu['id']; ?>">
                                                                <form name="add_item_frm" method="post" action="">
                                                                    <input type="hidden" name="menu_id" id="menu_id" value="<?php echo $array_menu['id']; ?>">
                                                                    <input type="hidden" name="size<?php echo $array_menu['id']; ?>" id="size<?php echo $array_menu['id']; ?>" value="<?php echo $array_menu['size']; ?>">
                                                                    <input type="hidden" name="restaurant_id<?php echo $array_menu['id']; ?>" id="restaurant_id<?php echo $array_menu['id']; ?>" value="<?php echo $_REQUEST['id']; ?>">
                                                                    <input type="hidden" name="menu_price<?php echo $array_menu['id']; ?>" id="menu_price<?php echo $array_menu['id']; ?>" value="<?php echo $array_menu['price']; ?>">
                                                                    <h2><?php echo $array_menu['menu_name']; ?>
                        <?php if ($array_menu['price'] != '') { ?>
                                                                            <span style="margin-left:10px;">$ <span id="menu_prc<?php echo $array_menu['id']; ?>"><?php echo $array_menu['price']; ?></span> </span>
                                                                    <?php } ?>
                                                                        <input type="hidden" name="hid_prc_menu<?php echo $array_menu['id']; ?>" id="hid_prc_menu<?php echo $array_menu['id']; ?>" value="<?php echo $array_menu['price']; ?>" />
                                                                        <a href="Javascript:void(0);" onClick="closeadditem('<?php echo $array_menu['id']; ?>')"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                                                        <?php /* ?><h3><?php echo $array_menu['menu_name'];?></h3><?php */ ?>
                                                                    <div style="height:auto; overflow:auto; padding-bottom:30px;">
                                                                                <?php /* ?><?php if($array_menu['price']!=''){?>
                                                                                  <span style="margin-left:10px;">$ <?php echo $array_menu['price']; ?>  </span><?php } ?><br><?php */ ?>
                                                                        <div class="right_inr_pop_div">
                                                                            <div class="r8_inr_txt">
                        <?php if ($array_menu['description'] != '') { ?>
                                                                                    <p style="border-bottom:none;"><?php echo $array_menu['description']; ?></p>
                        <?php } ?>
                                                                                <div class="clear"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="left_inr_pop_div">
                                                                            <?php
                                                                            $sql_select_special_instructions = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '" . $array_menu['id'] . "'");
                                                                            $in = 1;
                                                                            while ($array_special_instructions = mysql_fetch_array($sql_select_special_instructions)) {
                                                                                ?>
                                                                                <div class="pop_commnt">
                                                                                    <h3><?php echo $array_special_instructions['special_instruction']; ?></h3>
                                                                                    <div>
                                                                                        <?php
                                                                                        $sql_sub_ins = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '" . $array_special_instructions['id'] . "'");
                                                                                        $inn = 1;
                                                                                        while ($array_spl_ins = mysql_fetch_array($sql_sub_ins)) {
                                                                                            ?>
                                                                                          <div style="float:left; width:199px;"> <span style="width:17%; float:left; font:normal 15px calibri; letter-spacing:1px; display:block; "><!--<input name="radio<?php echo $array_menu['id']; ?>_<?php echo $array_special_instructions['id']; ?>" type="radio" value="<?php echo $array_spl_ins['price']; ?>" id="small<?php echo $array_menu['id']; ?>" /><?php echo $array_spl_ins['title']; ?>-->
                                                                                                    <input name="radio<?php echo $array_menu['id']; ?>_<?php echo $array_special_instructions['id']; ?>" type="radio" value="<?php echo $array_spl_ins['id']; ?>" id="small<?php echo $array_menu['id']; ?>" <?php if ($inn == 1) { ?> checked="checked" <?php } ?> style="margin-top:2px;" />
                                                                                                </span> <span style="width:83%; float:left; font:normal 15px calibri; letter-spacing:1px; display:block;"><?php echo $array_spl_ins['title']; ?> (+$<?php echo $array_spl_ins['price']; ?>)</span>
                                                                                                <div class="clear"></div>
                                                                                            </div>
                                                                                            <?php
                                                                                            $inn++;
                                                                                        }
                                                                                        ?>
                                                                                        <div class="clear"></div>
                                                                                    </div>
                                                                                    <div class="clear"></div>
                                                                                </div>
                                                                                <?php if ($in % 2 == 0) { ?>
                                                                                    <div class="clear"></div>
                                                                                <?php } ?>
                                                                                <?php
                                                                                $in++;
                                                                            }
                                                                            ?>
                                                                            <div class="clear"></div>
                                                                            <h4>Special Instructions</h4>
                                                                            <textarea name="special_instructions<?php echo $array_menu['id']; ?>" id="special_instructions<?php echo $array_menu['id']; ?>" cols="" rows=""></textarea>
                                                                            <div class="clear"></div>
                                                                            <div class="pop-fild-row" style="float:left">
                                                                                <h4>Quantity</h4>
                                                                                <div class="plus-minus"> <a class="plus" href="javascript:void(0);" onClick="count_down('<?php echo $array_menu['id']; ?>');"></a>
                                                                                    <input name="quantity<?php echo $array_menu['id']; ?>" id="quantity<?php echo $array_menu['id']; ?>" type="text" class="pop_quantity" value="1" onKeyPress="return goodchars(event, '1234567890');" readonly />
                                                                                    <a class="minus" href="javascript:void(0);" onClick="count_up('<?php echo $array_menu['id']; ?>');"></a> </div>
                                                                            </div>
                                                                            <div class="clear"></div>
                                                                            <?php /* ?><div style="margin-left:10px; margin-bottom:10px;" id="add_item_img<?php echo $array_menu['id'];?>">
                                                                              <img src="images/add_item.jpg" title="Add this item" ></div><?php */ ?>
                                                                            <?php
                                                                            $sql_select_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '" . $session_id . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
                                                                            $num_rows_items = mysql_num_rows($sql_select_items);
                                                                            ?>
                                                                            <div style="margin-top:0px !important;" id="add_item_btn<?php echo $array_menu['id']; ?>">
                                                                                <?php /* ?><?php if($num_rows_items == 0){ ?>
                                                                                  <a href="#" onClick="del_block(<?php echo $array_menu['id'];?>);"><img src="images/add_item1.jpg" title="Add this item" style="margin:10px;" ></a><?php } else { ?><?php */ ?>
                                                                                <input name="add" id="add" type="submit" value="ADD ITEM" class="pop_button" />
                        <?php /* ?><?php } ?><?php */ ?>
                                                                            </div>
                                                                            <div class="clear"></div>
                                                                        </div>
                                                                        <div class="clear"></div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="light_box_cam">
                                                                <h2 style="float:none;"> <a href="#top_div" onClick="add_item('<?php echo $array_menu['id']; ?>')" style="color:#EF7011;"><?php echo stripslashes($array_menu['menu_name']); ?></a>
                        <?php
                        if ($array_menu['menu_pic'] != "") {
                            ?>
                                                                        <a href="javascript:void(0);" class="highslide" onClick="open_single_slider_div(<?php echo $cnt; ?>);"> <img src="thumb_images/<?php echo $array_menu['menu_pic']; ?>" alt="<?php echo stripslashes($array_menu['menu_name']); ?>" title="Click to enlarge" height="30" width="30" style="margin-top:0px;" /></a> 
                                                                        <script type="text/javascript">
                                                                            var $j = jQuery.noConflict();
                                                                            //$j(window).load(function() {
                                                                            // The slider being synced must be initialized first
                                                                            /*$j('#carousel<?php echo $cnt; ?>').flexslider({
                                                                             animation: "slide",
                                                                             controlNav: false,
                                                                             animationLoop: false,
                                                                             slideshow: false,
                                                                             itemWidth: 100,
                                                                             itemMargin: 5,
                                                                             asNavFor: '#slider<?php echo $cnt; ?>'
                                                                             });*/

                                                                            $j('#slider<?php echo $cnt; ?>').flexslider({
                                                                                animation: "slide",
                                                                                controlNav: false,
                                                                                animationLoop: false,
                                                                                slideshow: false,
                                                                                //sync: "#carousel<?php echo $cnt; ?>"
                                                                            });
                                                                            //});
                                                                        </script>
                                                                        <div id="slider_div<?php echo $cnt; ?>" style="visibility:hidden;" class="white_content_new black_pop_bg"  >
                                                                            <div class="slide_head">
                                                                                <h1><?php echo stripslashes($array_menu['menu_name']); ?></h1>
                                                                            </div>
                                                                            <div class="close close-new" onClick="close_single_slider_div(<?php echo $cnt; ?>);"><a href = "javascript:void(0);"> </a> </div>
                                                                            <div class="l-contnt up-contnt">
                                                                                <div id="slider<?php echo $cnt; ?>" class="flexslider slider_flex" style="margin-bottom:27px;">
                                                                                    <ul class="slides">
                                                                                        <li>
                                                                                            <div><img src="uploaded_images/<?php echo $array_menu['menu_pic']; ?>"></div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                                <?php /* ?><div id="carousel<?php echo $cnt; ?>" class="flexslider carousel-flex">
                                                                                  <ul class="slides">
                                                                                  <li><img src="uploaded_images/<?php echo $array_menu['menu_pic'];?>"></li>
                                                                                  </ul>
                                                                                  </div><?php */ ?>
                                                                            </div>
                                                                        </div>
                                                                        <div id="fade1" class="black_overlay"> </div>
                                                                    <?php } ?>
                                                                    <?php if ($array_menu['whats_good'] == 1) { ?>
                                                                        <span style="margin-left: 5px;"><img src="images/whats_good.png" width="16" height="16"></span>
                                                                    <?php } ?>
                                                                    <?php if ($array_menu['spicy'] == 1) { ?>
                                                                        <span style="margin-left: 5px;"><img src="images/chilli-image.png" width="16" height="16"></span>
                                                                    <?php } ?>
                                                                    <?php if ($array_menu['veggie'] == 1) { ?>
                                                                        <span style="margin-left: 5px;"><img src="images/veggie.png" width="16" height="16"></span>
                                                                    <?php } ?>
                                                                        <?php if ($array_menu['healthy'] == 1) { ?>
                                                                        <span style="margin-left: 5px;"><img src="images/healthy.png" width="16" height="16"></span>
                                                                        <?php } ?>
                                                                    <span style="float:right; padding-right:10px;">
                                                                        <?php
                                                                        if ($array_menu['price'] != '' && $array_menu['price'] != '0.00') {
                                                                            echo "$ " . $array_menu['price'];
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                    <div style="clear:both;"></div>
                                                                </h2>

                                                                <!--<div class="highslide-gallery">--> 

                                                                <!--
                                                                                                                                            4) This is how you mark up the thumbnail image with an anchor tag around it.
                                                                                                                                            The anchor's href attribute defines the URL of the full-size image.
                                                                -->
                                                                <?php /* ?><?php
                                                                  if($array_menu['menu_pic']!="")
                                                                  {
                                                                  ?>
                                                                  <a href="uploaded_images/<?php echo $array_menu['menu_pic'];?>" class="highslide" onClick="return hs.expand(this)">
                                                                  <img src="thumb_images/<?php echo $array_menu['menu_pic'];?>" alt="<?php echo stripslashes($array_menu['menu_name']); ?>" title="Click to enlarge" /></a>
                                                                  <?php } ?><?php */ ?>
                                                                <!--
                                                                                                                                            5 (optional). This is how you mark up the caption. The correct class name is important.
                                                                --> 

                                                                <!--<div class="highslide-caption">
                                                                                                                                            Caption for the first image.
                                                                                                                                        </div>
                                                                                                                                        
                                                                                                                                        
                                                                                                                                        </div>--> 

                                                            </div>
                                                            <div class="clear"></div>
                                                            <p>
                                                            <?php if ($array_menu['description'] != "") { ?>
                                                                <?php echo $array_menu['description']; ?><br>
                                                            <?php } ?>
                                                            </p>
                                                            <?php
                                                            $cnt++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <p> No items Available</p>
                                                <?php } ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                } else {
                                    ?>
                                    <p style="font:14px Arial,Helvetica,sans-serif; text-align:center; padding:8px 0; color: #686868;">No items available</p>
                                <?php } ?>
                            </div>
                            <!-- <div class="restro_2left_panel_new" id="restro_2left_panel"> -->
                            <div id="restro_2left_panel" class="restro_2left_panel_new">
                                <?php
                                $sql_cart = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '" . $session_id . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
                                $cart_row = mysql_num_rows($sql_cart);
                                if ($cart_row == 0) {
                                    $display = 'block';
                                    $display1 = 'none';
                                } else {
                                    $display = 'none';
                                    $display1 = 'block';
                                }
                                ?>
                                <?php if ($_SESSION['group_order_details_id' . $ses_rest_id] == "") { ?>
                                    <div id="share_bar" class="share_sec">
                                        <h4>Group Order</h4>
                                        <a class="start_share" href="javascript:void(0)" onClick="open_shared_cart();" title="Start shared cart"> Start group order </a> </div>
<?php } else { ?>
                                    <div id="share_bar" class="share_bar_sec">
    <?php $is_admin = getNameTable("restaurant_group_order_details", "is_admin", "id", $_SESSION['group_order_details_id' . $ses_rest_id]); ?>
                                        <h4><?php echo $adm_name = getNameTable("restaurant_group_order_details", "name", "id", $_SESSION['group_order_details_id' . $ses_rest_id]); ?>'s Cart</h4>
                                        <p><span class="share_txt_lnk">Link:</span> <span class="share_link">
                                                <input type="text" name="lnk" id="lnk" class="link_input" value="<?php echo getNameTable("restaurant_group_order", "share_link", "id", $_SESSION['group_order_id' . $ses_rest_id]); ?>" />
                                            </span></p>
                                        <div class="clear"></div>
                                        <div class="share_icon_sec">
                                            <p><span class="share_txt">Share By</span> <span class="email_txt_right"><a href="javascript:void(0);" id="email_top_a" onClick="email_top_div_show()">Email</a></span> </p>
                                            <div class="clear"></div>
                                            <div id="email_top_div" style="display:none;" class="mail_div_nw">
                                                <input type="text" name="email_top" id="email_top" placeholder="Enter the Email" class="restaurant">
                                                <input type="hidden" id="link_top" value="<?php echo getNameTable("restaurant_group_order", "share_link", "id", $_SESSION['group_order_id' . $ses_rest_id]); ?>">
                                                <input type="button" name="send" id="send" value="Send" onClick="send_top_email();" class="mail_send_butt">
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    <?php if ($is_admin == 0) { ?>
                                            <a class="leave_grp" href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&session_group=<?php echo $_SESSION['group_order_details_id' . $ses_rest_id]; ?>&res_id=<?php echo $_REQUEST['id']; ?>" onClick="return confirm('Are you sure to Leave the Group?');"><img src="images/cross-icon.png" /> Leave Goup Order</a>
    <?php } ?>
                                    </div>
<?php } ?>
                                <div class="clear"></div>
                                <div class="rstrnt_right_panel2 review-restu">
                                    <div class="rstrnt_right_panel  rstrnt_right_panel_new" style="display:block;">
                                        <div class="rstrnt2_reviews_rtngs rstrnt2_reviews_rtngs_new">
                                            <div class="star-rate1s">
                                                        <?php $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $_REQUEST['id'] . "'")); ?>
                                                <div class="reviews_pop rev_pop_nw ppp " style="display:none; width:580px;" id="local_review">
                                                    <h2><?php echo stripslashes($sql_restaurant['restaurant_name']); ?><a href="Javascript:void(0);" onClick="closesidetab()"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                                    <div style="height:350px; overflow:auto;"> <a class="fr-light" href="write_review.php?id=<?php echo $_REQUEST['id']; ?>" style="color:rgb(228, 96, 2); font:normal 20px 'Calibri'; float:right; margin-right: 27px; margin-bottom: 10px;"> Write A Review </a>
                                                        <?php
                                                        $sql_reviews = mysql_query("SELECT rr.id,rr.post_date,rr.customer_name,rr.customer_email,rr.customer_picture, rr.customer_review,rr.restaurant_id, rr.customer_id , rr.restaurant_name , rr.like , rr.dislike ,  rrat.rating_id ,  rrat.rating_id FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='" . $_REQUEST['id'] . "' AND rrat.restaurant_id='" . $_REQUEST['id'] . "' AND rr.status=1 AND rr.review_status = 0 ORDER BY rr.id DESC");

                                                        //$sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$_REQUEST['id']."' AND parent_id = '0' ORDER BY post_date DESC");

                                                        $rev_counter = 1;
                                                        while ($array_reviews = mysql_fetch_array($sql_reviews)) {

                                                            $sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND parent_id = '" . $array_reviews['id'] . "' AND review_status = 1 ORDER BY post_date DESC");
                                                            ?>
                                                            <div class="pop_commnt pop-fr-light">
                                                                <?php
                                                                $iinc = 1;
                                                                while ($row_updated_review = mysql_fetch_array($sql_updated_review)) {

                                                                    $rating_updated = getSingleReviewRating($row_updated_review['restaurant_id'], $row_updated_review['id']);

                                                                    $sql_prev_check = mysql_num_rows(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '" . $array_reviews['id'] . "'"));


                                                                    if ($iinc == 2) {
                                                                        $prev_rev_stat = 'Previous Review';
                                                                    } else {
                                                                        $prev_rev_stat = '';
                                                                    }
                                                                    ?>
                                                                    <div id="updated_reviews" class="separetor" style="margin-bottom:50px;">
                                                                        <?php
                                                                        $sql_upd_rev = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '" . $array_reviews['id'] . "' ORDER BY id DESC"));


                                                                        if ($row_updated_review['id'] == $sql_upd_rev['id']) {
                                                                            $upd_status = "Updated Review";
                                                                        } else {
                                                                            $upd_status = "";
                                                                        }
                                                                        ?>
        <?php /* ?> <h5 class="rv-date-tm">
          <?php echo change_dateformat_reverse($row_updated_review['post_date']); ?>  By <span><?php echo $row_updated_review['customer_name']?></span>  </h5><?php */ ?>
                                                                        Date : <?php echo date("d-m-Y", strtotime($row_updated_review['post_date'])); ?><br />
                                                                        <div class="rating_content light-rating">
                                                                            <ul>
                                                                                <?php
                                                                                $rem = 5 - $rating_updated;
                                                                                if ($rating_updated > 0) {
                                                                                    for ($i = 0; $i < $rating_updated; $i++) {
                                                                                        ?>
                                                                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                        <?php
                                                                                    }
                                                                                    for ($j = 0; $j < $rem; $j++) {
                                                                                        ?>
                                                                                        <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                        <?php
                                                                                    }
                                                                                } else {
                                                                                    ?>
                                                                                    <li>
                                                                                        <div style="width:165px;">&nbsp;</div>
                                                                                    </li>
            <?php
        }
        ?>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="rating_content_two review-likes"> <span class="status-review light-stats"><!-- <a href=""> -->
        <?php if ($upd_status != '') { ?>
                                                                                    <img src="../images/refesh-org.png" align="absmiddle"  width="14px" />
                                                                        <?php } ?>
                                                                                <!-- </a> --><?php echo $prev_rev_stat; ?> <?php echo $upd_status; ?> </span> </div>
                                                                        <div class="clear"></div>
                                                                        <?php
                                                                        $sql_mul_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '" . $row_updated_review['id'] . "'");
                                                                        ?>
                                                                        <p style="margin-top:0px; margin-bottom:10px;"><?php echo $row_updated_review['customer_name']; ?></p>
                                                                                <?php echo $row_updated_review['customer_review'] ?>
                                                                        <div class="rv-img">
                                                                            <ul>
                                                                                <?php
                                                                                //echo mysql_num_rows($sql_mul_image);

                                                                                if (mysql_num_rows($sql_mul_image) != 0) {
                                                                                    while ($mul_image = mysql_fetch_array($sql_mul_image)) {
                                                                                        $uploaded_image = 'uploaded_images/' . $mul_image['image'];
                                                                                        ?>
                                                                                        <li><a class="example_cat" href="<?php echo $uploaded_image; ?>"><img src="uploaded_images/<?php echo $mul_image['image']; ?>" height="30"></a></li>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </ul>
                                                                        </div>
                                                                        <?php if ($row_updated_review['abuse_status'] == 0) { ?>
                                                                            <div class="clear"></div>
                                                                            <?php
                                                                            $sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '" . $row_updated_review['id'] . "'"));
                                                                            if (!empty($sql_owners_comment)) {
                                                                                $sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '" . $sql_owners_comment['restaurant_owner_id'] . "'"));
                                                                                ?>
                                                                                <div class="next-review">
                                                                                    <div class="next-review-head">
                                                                                        <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info", "restaurant_name", "id", $row_updated_review['restaurant_id']); ?></strong></p>
                                                                                        <p>Business Owner</p>
                                                                                    </div>
                                                                                    <label><?php echo date("m-d-Y", strtotime($sql_owners_comment['post_date'])); ?> - <?php echo "Hi " . $row_updated_review['customer_name']; ?></label>
                                                                                    <div class="next-review-cont"><?php echo $sql_owners_comment['comment']; ?></div>
                                                                                    <div class="clear"></div>
                                                                                </div>
                                                                        <?php } ?>
                                                                            <div class="clear"></div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    $iinc++;
                                                                }
                                                                ?>
                                                                Date : <?php echo date("d-m-Y", strtotime($array_reviews['post_date'])); ?><br>
                                                                <?php
                                                                $rating = number_format(getSingleReviewRating($array_reviews['restaurant_id'], $array_reviews['id']));
                                                                //echo $rating = 3; 
                                                                ?>
                                                                <?php
                                                                $one_decimal_place = number_format($rating, 1);
                                                                $rat_pt = (explode(".", $rating));
                                                                $rat_pt[0];
                                                                $rat_pt[1];

                                                                $rem = 5 - $rat_pt[0];


                                                                if ($rating == 0) {
                                                                    for ($i = 0; $i < 5; $i++) {
                                                                        ?>
                                                                        <img width="16" height="15" src="images/star-3.png">
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    if ($rat_pt[1] < 3 && $rat_pt[1] != 0) {
                                                                        for ($i = 1; $i <= $rating; $i++) {
                                                                            ?>
                                                                            <img width="16" height="16" src="images/star-1.png">
                                                                            <?php
                                                                        }
                                                                    } else if ($rat_pt[1] > 7) {
                                                                        for ($i = 1; $i <= $rating + 1; $i++) {
                                                                            ?>
                                                                            <img width="16" height="16" src="images/star-1.png">
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        for ($i = 1; $i <= $rating; $i++) {
                                                                            ?>
                                                                            <img width="16" height="16" src="images/star-1.png">
                                                                            <?php
                                                                        }
                                                                    }
                                                                    if ($rat_pt[1] != '' && $rat_pt[1] > 2 && $rat_pt[1] < 8) {
                                                                        ?>
                                                                        <img width="16" height="15" src="images/star-2.png">
                                                                        <?php
                                                                    }
                                                                    if ($rat_pt[1] != '' && $rat_pt[1] > 2 && $rat_pt[1] <= 9) {
                                                                        for ($j = 1; $j <= $rem - 1; $j++) {
                                                                            ?>
                                                                            <img width="16" height="15" src="images/star-3.png">
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        for ($j = 1; $j <= $rem; $j++) {
                                                                            ?>
                                                                            <img width="16" height="15" src="images/star-3.png">
                                                                            <?php
                                                                        }
                                                                    }
                                                                }

                                                                $rev_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='" . $_REQUEST['id'] . "' AND rrat.restaurant_id='" . $_REQUEST['id'] . "' AND rr.status=1 AND rr.customer_id = '" . $array_reviews['customer_id'] . "' ORDER BY rr.id DESC"));

                                                                if ($rev_count == 2) {
                                                                    $prev_status = "Previous Review";
                                                                } else {
                                                                    $prev_status = '';
                                                                }
                                                                ?>
                                                                <span class="status-review"> <?php echo $prev_status; ?> <!-- <a href=""> <img width="14px" align="absmiddle" src="../images/refesh-org.png"></a>--> </span>
                                                                <div class="clear"></div>
                                                                <p style="margin-top:0px; margin-bottom:10px;"><?php echo $array_reviews['customer_name']; ?></p>
                                                                        <?php echo $array_reviews['customer_review']; ?>
                                                                <div class="rv-img">
                                                                    <ul>
                                                                        <?php
                                                                        //echo mysql_num_rows($sql_mul_image);

                                                                        $sql_mul_image1 = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '" . $array_reviews['id'] . "'");

                                                                        if (mysql_num_rows($sql_mul_image1) != 0) {
                                                                            while ($mul_image1 = mysql_fetch_array($sql_mul_image1)) {
                                                                                $uploaded_image = 'uploaded_images/' . $mul_image1['image'];
                                                                                ?>
                                                                                <li><a class="example_cat" href="<?php echo $uploaded_image; ?>"><img src="uploaded_images/<?php echo $mul_image1['image']; ?>" height="30"></a></li>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                                <?php if ($array_reviews['abuse_status'] == 0) { ?>
                                                                    <div class="clear"></div>
                                                                    <?php
                                                                    $sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '" . $array_reviews['id'] . "'"));
                                                                    if (!empty($sql_owners_comment1)) {
                                                                        $sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '" . $sql_owners_comment1['restaurant_owner_id'] . "'"));
                                                                        ?>
                                                                        <div class="next-review">
                                                                            <div class="next-review-head">
                                                                                <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info", "restaurant_name", "id", $array_reviews['restaurant_id']); ?></strong></p>
                                                                                <p>Business Owner</p>
                                                                            </div>
                                                                            <label><?php echo date("m-d-Y", strtotime($sql_owners_comment1['post_date'])); ?> - <?php echo "Hi " . $array_reviews['customer_name']; ?></label>
                                                                            <div class="next-review-cont"><?php echo $sql_owners_comment1['comment']; ?></div>
                                                                            <div class="clear"></div>
                                                                        </div>
                                                                <?php } ?>
                                                                    <div class="clear"></div>
                                                            <?php } ?>
                                                            </div>
                                                            <?php
                                                            $rev_counter++;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-------------------- popular pop item --------------------------------------------->
                                            <div class="reviews_pop rev_pop_item_box fd-pop" style="display:none;" id="popular_item">
                                                <h2><?php echo stripslashes($sql_restaurant['restaurant_name']); ?><a href="Javascript:void(0);" onClick="closepopularitem()" style="float:right;"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                                <div class="restro_fution">
                                                    <?php $sql_restaurant_category = mysql_query("SELECT * FROM restaurant_category WHERE id IN(" . $sql_restaurant['restaurant_category'] . ")"); ?>
                                                    <?php
                                                    $i = 1;
                                                    while ($result_restaurant_category = mysql_fetch_array($sql_restaurant_category)) {
                                                        ?>
                                                        <span><?php echo $result_restaurant_category['category_name']; ?>
                                                            <?php
                                                            if ($i != mysql_num_rows($sql_restaurant_category)) {
                                                                echo ",";
                                                            }
                                                            ?>
                                                        </span>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="popcon"> 
                                                    <!------------------------------------ Monday Business Hours -------------------------->
                                                    <?php
                                                    $sql_monday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND days_id = 1");
                                                    $id_mon = 1;
                                                    while ($array_monday_hrs = mysql_fetch_array($sql_monday_buss_hrs)) {
                                                        echo '<p class="timerow">';
                                                        if ($id_mon == 1) {
                                                            echo "<strong>Monday Business Hours  </strong>";
                                                        }
                                                        echo '<span>: ' . $array_monday_hrs['time_from'] . " to " . $array_monday_hrs['time_to'] . '</span>';
                                                        $id_mon++;
                                                        echo '</p>';
                                                    }
                                                    ?>
                                                    <!------------------------------------ Monday Business Hours --------------------------> 

                                                    <!------------------------------------ Tuesday Business Hours -------------------------->
                                                    <?php
                                                    $sql_tuesday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND days_id = 2");
                                                    $id_tue = 1;
                                                    while ($array_tuesday_hrs = mysql_fetch_array($sql_tuesday_buss_hrs)) {
                                                        echo '<p class="timerow">';
                                                        if ($id_tue == 1) {
                                                            echo "<strong>Tuesday Business Hours </strong>";
                                                        }
                                                        echo '<span>: ' . $array_tuesday_hrs['time_from'] . " to " . $array_tuesday_hrs['time_to'] . '</span>';
                                                        $id_tue++;
                                                        echo '</p>';
                                                    }
                                                    ?>
                                                    <!------------------------------------ Tuesday Business Hours --------------------------> 

                                                    <!------------------------------------ Wednesday Business Hours -------------------------->
                                                    <?php
                                                    $sql_wednesday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND days_id = 3");
                                                    $id_wed = 1;
                                                    while ($array_wednesday_hrs = mysql_fetch_array($sql_wednesday_buss_hrs)) {
                                                        echo '<p class="timerow">';
                                                        if ($id_wed == 1) {
                                                            echo "<strong>Wednesday Business Hours </strong>";
                                                        }
                                                        echo '<span>: ' . $array_wednesday_hrs['time_from'] . " to " . $array_wednesday_hrs['time_to'] . '</span>';
                                                        $id_wed++;
                                                        echo '</p>';
                                                    }
                                                    ?>
                                                    <!------------------------------------ Wednesday Business Hours --------------------------> 

                                                    <!------------------------------------ Thursday Business Hours -------------------------->
                                                    <?php
                                                    $sql_thursday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND days_id = 4");
                                                    $id_thu = 1;
                                                    while ($array_thursday_hrs = mysql_fetch_array($sql_thursday_buss_hrs)) {
                                                        echo '<p class="timerow">';
                                                        if ($id_thu == 1) {
                                                            echo "<strong>Thursday Business Hours </strong> ";
                                                        }
                                                        echo '<span>: ' . $array_thursday_hrs['time_from'] . " to " . $array_thursday_hrs['time_to'] . '</span>';
                                                        $id_thu++;
                                                        echo '</p>';
                                                    }
                                                    ?>
                                                    <!------------------------------------ Thursday Business Hours --------------------------> 

                                                    <!------------------------------------ Friday Business Hours -------------------------->
                                                    <?php
                                                    $sql_friday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND days_id = 5");
                                                    $id_fri = 1;
                                                    while ($array_friday_hrs = mysql_fetch_array($sql_friday_buss_hrs)) {
                                                        echo '<p class="timerow">';
                                                        if ($id_fri == 1) {
                                                            echo "<strong>Friday Business Hours </strong>";
                                                        }
                                                        echo '<span>: ' . $array_friday_hrs['time_from'] . " to " . $array_friday_hrs['time_to'] . '</span>';
                                                        $id_fri++;
                                                        echo '</p>';
                                                    }
                                                    ?>
                                                    <!------------------------------------ Friday Business Hours --------------------------> 

                                                    <!------------------------------------ Saturday Business Hours -------------------------->
                                                    <?php
                                                    $sql_saturday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND days_id = 6");
                                                    $id_sat = 1;
                                                    while ($array_saturday_hrs = mysql_fetch_array($sql_saturday_buss_hrs)) {
                                                        echo '<p class="timerow">';
                                                        if ($id_sat == 1) {
                                                            echo "<strong>Saturday Business Hours </strong> ";
                                                        }
                                                        echo '<span>: ' . $array_saturday_hrs['time_from'] . " to " . $array_saturday_hrs['time_to'] . '</span>';
                                                        $id_sat++;
                                                        echo '</p>';
                                                    }
                                                    ?>
                                                    <!------------------------------------ Saturday Business Hours --------------------------> 

                                                    <!------------------------------------ Sunday Business Hours -------------------------->
                                                    <?php
                                                    $sql_sunday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND days_id = 7");
                                                    $id_sun = 1;
                                                    while ($array_sunday_hrs = mysql_fetch_array($sql_sunday_buss_hrs)) {
                                                        echo '<p class="timerow">';
                                                        if ($id_sun == 1) {
                                                            echo "<strong>Sunday Business Hours </strong> ";
                                                        }
                                                        echo '<span>: ' . $array_sunday_hrs['time_from'] . " to " . $array_sunday_hrs['time_to'] . '</span>';
                                                        $id_sun++;
                                                        echo '</p>';
                                                    }
                                                    ?>
                                                    <!------------------------------------ Sunday Business Hours --------------------------> 

                                                </div>
                                                <?php /* ?><?php $sql_delivery = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['id']."'"));?><?php */ ?>
                                                <?php /* ?><table width="500" border="0" cellspacing="10" cellpadding="3">
                                                  <?php if(!empty($sql_delivery['business_hours_mon_from'])){?>
                                                  <tr>
                                                  <td class="fll_hr">Monday</td>
                                                  <td><?php echo $sql_delivery['business_hours_mon_from']; ?> to <?php echo $sql_delivery['business_hours_mon']; ?></td>
                                                  </tr>
                                                  <?php } ?>
                                                  <?php if(!empty($sql_delivery['business_hours_tue_from'])){?>
                                                  <tr>
                                                  <td class="fll_hr">Tuesday</td>
                                                  <td><?php echo $sql_delivery['business_hours_tue_from']; ?> to <?php echo $sql_delivery['business_hours_tue']; ?></td>
                                                  </tr>
                                                  <?php } ?>
                                                  <?php if(!empty($sql_delivery['business_hours_wed_from'])){?>
                                                  <tr>
                                                  <td class="fll_hr">Wednesday</td>
                                                  <td><?php echo $sql_delivery['business_hours_wed_from']; ?> to <?php echo $sql_delivery['business_hours_wed']; ?></td>
                                                  </tr>
                                                  <?php } ?>
                                                  <?php if(!empty($sql_delivery['business_hours_thu_from'])){?>
                                                  <tr>
                                                  <td class="fll_hr">Thursday</td>
                                                  <td><?php echo $sql_delivery['business_hours_thu_from']; ?> to <?php echo $sql_delivery['business_hours_thu']; ?></td>
                                                  </tr>
                                                  <?php } ?>
                                                  <?php if(!empty($sql_delivery['business_hours_fri_from'])){?>
                                                  <tr>
                                                  <td class="fll_hr">Friday</td>
                                                  <td><?php echo $sql_delivery['business_hours_fri_from']; ?> to <?php echo $sql_delivery['business_hours_fri']; ?></td>
                                                  </tr>
                                                  <?php } ?>
                                                  <?php if(!empty($sql_delivery['business_hours_sat_from'])){?>
                                                  <tr>
                                                  <td class="fll_hr">Saturday</td>
                                                  <td><?php echo $sql_delivery['business_hours_sat_from']; ?> to <?php echo $sql_delivery['business_hours_sat']; ?></td>
                                                  </tr>
                                                  <?php } ?>
                                                  <?php if(!empty($sql_delivery['business_hours_sun_from'])){?>
                                                  <tr>
                                                  <td class="fll_hr">Sunday</td>
                                                  <td><?php echo $sql_delivery['business_hours_sun_from']; ?> to <?php echo $sql_delivery['business_hours_sun']; ?></td>
                                                  </tr>
                                                  <?php } ?>
                                                  </table><?php */ ?>
                                            </div>
                                            <!-------------------- popular pop item --------------------------------------------->

                                            <div>
                                                <div class="rstrnt2_rtngs">
                                                    <?php
                                                    $sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND status = 1");
                                                    $no_reviews = mysql_num_rows($sql_reviews);
                                                    ?>
                                                    <div>
                                                        <?php
                                                        $rating = number_format(getRestaurantRating($_REQUEST['id']), 1);

                                                        //echo $rating = 3; 
                                                        ?>
                                                        <?php
                                                        $one_decimal_place = number_format($rating, 1);
                                                        $rat_pt = (explode(".", $rating));
                                                        $rat_pt[0];
                                                        $rat_pt[1];

                                                        $rem = 5 - $rat_pt[0];


                                                        if ($rating == 0) {
                                                            for ($i = 0; $i < 5; $i++) {
                                                                ?>
                                                                <img width="16" height="15" src="images/star-3.png">
                                                                <?php
                                                            }
                                                        } else {
                                                            if ($rat_pt[1] < 3 && $rat_pt[1] != 0) {
                                                                for ($i = 1; $i <= $rating; $i++) {
                                                                    ?>
                                                                    <img width="16" height="16" src="images/star-1.png">
                                                                    <?php
                                                                }
                                                            } else if ($rat_pt[1] > 7) {
                                                                for ($i = 1; $i <= $rating + 1; $i++) {
                                                                    ?>
                                                                    <img width="16" height="16" src="images/star-1.png">
                                                                    <?php
                                                                }
                                                            } else {
                                                                for ($i = 1; $i <= $rating; $i++) {
                                                                    ?>
                                                                    <img width="16" height="16" src="images/star-1.png">
                                                                    <?php
                                                                }
                                                            }
                                                            if ($rat_pt[1] != '' && $rat_pt[1] > 2 && $rat_pt[1] < 8) {
                                                                ?>
                                                                <img width="16" height="15" src="images/star-2.png">
                                                                <?php
                                                            }
                                                            if ($rat_pt[1] != '' && $rat_pt[1] > 2 && $rat_pt[1] <= 9) {
                                                                for ($j = 1; $j <= $rem - 1; $j++) {
                                                                    ?>
                                                                    <img width="16" height="15" src="images/star-3.png">
                                                                    <?php
                                                                }
                                                            } else {
                                                                for ($j = 1; $j <= $rem; $j++) {
                                                                    ?>
                                                                    <img width="16" height="15" src="images/star-3.png">
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <h2 class="local_reviews">
                                                        <?php if ($no_reviews == 0) { ?>
                                                            <?php echo $no_reviews; ?> Reviews
<?php } else { ?>
                                                            <a href="#top_div" onClick="showsidetab()"><?php echo $no_reviews; ?> Reviews </a>
<?php } ?>
                                                    </h2>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <?php /* ?><h2 class="local_reviews"> 
                                          <?php if($no_reviews == 0){?>
                                          <?php echo $no_reviews; ?> Reviews
                                          <?php }else { ?>
                                          <a href="#top_div" onClick="showsidetab()"><?php echo $no_reviews; ?> Reviews </a>
                                          <?php } ?></h2><?php */ ?>
                                        <div class="rstrnt2_mre_info">
                                            <?php /* ?><p><?php if(!empty($sql_restaurant['phone'])) { echo $sql_restaurant['phone']; }?><br /><br>

                                              <span>
                                              <?php echo $sql_restaurant['restaurant_address'];?><br>
                                              <?php echo $sql_restaurant['restaurant_city'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_state'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_zipcode'];?></span>
                                              </p><?php */ ?>
                                            <div class="pckup">
                                                <?php
                                                $sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $_REQUEST['id'] . "'"));
                                                $address = $sql_select_add['restaurant_address'] . " " . $sql_select_add['restaurant_city'] . " " . $sql_select_add['restaurant_state'] . " " . $sql_select_add['restaurant_zipcode'];
                                                $address_map = str_replace(" ", "%20", $address);
                                                $address_map = str_replace("#", "%23", $address_map);
                                                ?>
                                                <?php
                                                $timezone = getTimezone($address);

                                                if ($timezone != '') {
                                                    date_default_timezone_set($timezone);
                                                } else {
                                                    date_default_timezone_set('America/Chicago');
                                                }

                                                $current_time_home = date('h:i A');

                                                $timestamp = time();
                                                $time = date("G:i:s");
                                                //$time = "10:15:00";

                                                $time1 = strtotime($time);



                                                $today = strtolower(date('l'));

                                                $day = strtolower(substr($today, 0, 3));

                                                $sql_bus_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '" . $_REQUEST['id'] . "'"));

                                                $sql_pickup_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_take_out_master WHERE restaurant_id = '" . $_REQUEST['id'] . "'"));

                                                $sql_del_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_delivery_details_master WHERE restaurant_id = '" . $_REQUEST['id'] . "'"));

                                                $time_from_pickup = $sql_pickup_time['from_time_' . $today];
                                                $time_to_pickup = $sql_pickup_time['to_time_' . $today];

                                                $time_from_del = $sql_del_time['delivery_from_' . $today];
                                                $time_to_del = $sql_del_time['delivery_to_' . $today];

                                                $time_from = $sql_bus_time['business_hours_' . $day . '_from'];
                                                $time_to = $sql_bus_time['business_hours_' . $day];


                                                $current_time1 = DateTime::createFromFormat('H:i A', $current_time_home);
                                                $time1 = DateTime::createFromFormat('H:i A', $time_from_pickup);
                                                $time2 = DateTime::createFromFormat('H:i A', $time_to_pickup);

                                                $time3 = DateTime::createFromFormat('H:i A', $time_from_del);
                                                $time4 = DateTime::createFromFormat('H:i A', $time_to_del);

                                                $time11 = DateTime::createFromFormat('H:i A', $time_from);
                                                $time22 = DateTime::createFromFormat('H:i A', $time_to);


                                                /*************************************** BUSINESS HOURS *********************************** */

                                                $sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '" . $_REQUEST['id'] . "' AND holiday_date = '" . date('Y-m-d') . "'");
                                                $restaurant_holiday = '';
                                                while ($array_holidays = mysql_fetch_array($sql_holidays)) {
                                                    $holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
                                                    $holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);

                                                    if ($current_time1 > $holiday_from && $current_time1 < $holiday_to) {
                                                        $restaurant_holiday = 'close';
                                                    }
                                                }



                                                if ($restaurant_holiday != 'close') {
                                                    $sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '" . $today . "'"));
                                                    $sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
                                                    $restaurant_status = '';
                                                    while ($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)) {
                                                        $new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
                                                        $new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);

                                                        if ($current_time1 > $new_from_tm && $current_time1 < $new_to_tm) {
                                                            $restaurant_status = 'open';
                                                        }
                                                    }
                                                } else {
                                                    $restaurant_status = '';
                                                }


                                                $sql_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
                                                $restaurant_pickup_status = '';
                                                while ($array_pickup_hrs = mysql_fetch_array($sql_pickup_hrs)) {
                                                    $pickup_from_tm = DateTime::createFromFormat('H:i A', $array_pickup_hrs['time_from']);
                                                    $pickup_to_tm = DateTime::createFromFormat('H:i A', $array_pickup_hrs['time_to']);

                                                    if ($current_time1 > $pickup_from_tm && $current_time1 < $pickup_to_tm) {
                                                        $restaurant_pickup_status = 'open';
                                                    }
                                                }


                                                $sql_delivery_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $_REQUEST['id'] . "'");
                                                $restaurant_delivery_status = '';
                                                while ($array_delivery_hrs = mysql_fetch_array($sql_delivery_hrs)) {
                                                    $delivery_from_tm = DateTime::createFromFormat('H:i A', $array_delivery_hrs['time_from']);
                                                    $delivery_to_tm = DateTime::createFromFormat('H:i A', $array_delivery_hrs['time_to']);

                                                    if ($current_time1 > $delivery_from_tm && $current_time1 < $delivery_to_tm) {
                                                        $restaurant_delivery_status = 'open';
                                                    }
                                                }


                                                if ($restaurant_status == 'open') {
                                                    $open = "<p>Open Now</p>";
                                                    $flag = 1;
                                                    if ($restaurant_pickup_status == 'open') {
                                                        $Pickup_available = 'Available';
                                                    } else {
                                                        $Pickup_available = 'Unavailable';
                                                    }

                                                    if ($restaurant_delivery_status == 'open') {
                                                        $Delivery_available = 'Available';
                                                    } else {
                                                        $Delivery_available = 'Unavailable';
                                                    }
                                                } else {
                                                    $flag = 0;
                                                    $open = "<p style='color:#ff0000; font-weight:bold; font-size:17px;'>Close Right Now</p>";
                                                }

                                                /* if(($current_time1 > $time11 && $current_time1 < $time22))
                                                  {
                                                  $open = "<p style='color:#9AA930; font-weight:bold; font-size:17px;'>Open Now</p>";
                                                  $flag = 1;

                                                  if(($current_time1 > $time1 && $current_time1 < $time2) || ($time_from_pickup == '' && $time_to_pickup == ''))
                                                  {
                                                  $Pickup_available = 'Available';
                                                  }
                                                  else
                                                  {
                                                  $Pickup_available = 'Unavailable';
                                                  }

                                                  if(($current_time1 > $time3 && $current_time1 < $time4) || ($time_from_del == '' && $time_to_del == ''))
                                                  {
                                                  $Delivery_available = 'Available';
                                                  }
                                                  else
                                                  {
                                                  $Delivery_available = 'Unavailable';
                                                  }
                                                  }
                                                  else{
                                                  $flag = 0;
                                                  $open = "<p style='color:#ff0000; font-weight:bold; font-size:17px;'>Close Right Now</p>";
                                                  } */
                                                ?>
                                                <div class="gap"> <?php echo $open; ?>
                                                    <?php
                                                    if ($sql_delivery['pickup'] == 1) {
                                                        if ($Pickup_available != '') {
                                                            ?>
                                                            <h4>Pickup - <span class="pick-up">
                                                            <?php
                                                            echo $Pickup_available;
                                                            ?>
                                                                </span> </h4>
                                                            <?php
                                                        }
                                                        if ($flag == 1) {
                                                            /* if($time_from_pickup!= '' && $time_to_pickup!= ''){
                                                              echo $time_from_pickup." to ".$time_to_pickup."<br>";
                                                              } */

                                                            while ($array_pickup_hrs = mysql_fetch_array($sql_pickup_hrs)) {
                                                                echo $array_pickup_hrs['time_from'] . " to " . $array_pickup_hrs['time_to'] . "<br>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div> </div>
                                                <div class="gap gap2">
                                                            <?php if ($Delivery_available != '') { ?>
                                                        <h4>Delivery - <span class="pick-up">
                                                                <?php
                                                                if ($sql_delivery['delivery'] == 1) {
                                                                    echo $Delivery_available;
                                                                    //echo "Available";
                                                                    ?>
                                                                </span> </h4>
                                                        <?php } ?>
                                                        <div class="clear"></div>
                                                        <?php
                                                        if ($flag == 1) {
                                                            /* if($time_from_del!= '' && $time_to_del!= '')
                                                              {
                                                              echo $time_from_del." to ".$time_to_del."<br>";
                                                              } */
                                                            while ($array_delivery_hrs = mysql_fetch_array($sql_delivery_hrs)) {
                                                                echo $array_delivery_hrs['time_from'] . " to " . $array_delivery_hrs['time_to'] . "<br>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?php if ($sql_delivery['delivery'] == 1) { ?>
                                                            <?php /* ?> <?php if($time_from_del!= '' && $time_to_del!= ''){ ?>
                                                              <p>Delivery Hours<?php echo $time_from_del." to ".$time_to_del;?></p>
                                                              <?php } ?><?php */ ?>
                                                        <div>
                                                            <?php if (!empty($sql_delivery['minimum_ammount'])) { ?>
                                                                <p>Minimum delivery order of $<?php echo $sql_delivery['minimum_ammount']; ?></p>
                                                            <?php } ?>
                                                            <?php if (!empty($sql_delivery['delivery_estimated_time'])) { ?>
                                                                <p>Delivery Estimates <?php echo $sql_delivery['delivery_estimated_time']; ?></p>
    <?php } ?>
<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <h2 class="popular_item"><a href="#top_div" onClick="popularitem()">More Business Info... </a></h2>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($_SESSION['group_order_details_id' . $ses_rest_id] == "") { ?>
                                    <!------------------------------------ SINGLE CART------------------------------------------>
                                    
                                    <script type="text/javascript">
									var $j = jQuery.noConflict();
									
									var navWrap = $j('#navigation_single_cart'),
											startPosition = navWrap.offset().top,
											stopPosition = $j('#stopHere_single_cart').offset().top - navWrap.outerHeight();
												
									$j(document).scroll(function () {
										var y = $j(this).scrollTop()
										var start_pt = $j("#start_div_single_cart").offset().top - 130;
										var end_pt = $j("#stopHere_single_cart").offset().top-620;
										
										
										if (y > start_pt && y < end_pt) {
											
											navWrap.removeClass('fix_map');
											navWrap.addClass('sticky');
											if (y > end_pt){
												navWrap.css('top', 0);
											} else {
												navWrap.css('top', 160);
											}
										}else {
											if(y <= start_pt){
												navWrap.removeClass('sticky');
												navWrap.css({'top':'0','bottom' : '300'});
											}else{
												navWrap.removeClass('sticky');
												navWrap.addClass('fix_map');
												navWrap.css({'top':'auto','bottom' : '300'});
											}
											
										}
									});
								</script>
                                
                                <div id="start_div_single_cart"></div>

                                    <?php
                                    $sql_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '" . $session_id . "' AND restaurant_id = '" . $_REQUEST['id'] . "' AND group_id = '0' AND group_order_details_id = '0'");
                                    if (mysql_num_rows($sql_items) > 0) {
                                        ?>
                                        <div id="navigation_single_cart" class="rstrnt_right_panel rstrnt_right_panel_new ur-order" style="display:<?php echo $display1; ?>; margin-top:10px;">
                                            <div class="rstrnt2_mre_info rstrnt2_mre_info_new">
                                                <h2 class="restrnt2_order">Your Order</h2>
                                                <?php /* ?> <?php if($del_hours_from!='' && $del_hours_to!=''){
                                                  if(($time1 >$del_hours_from  && $time1 <$del_hours_to)){
                                                  }else { ?>
                                                  <p style="color:#C00007; font-size:16px;">Not taking orders for delivery at this time.</p>
                                                  <?php }
                                                  }?><?php */ ?>
                                                <?php if ($restaurant_delivery_status != 'open') { ?>
                                                    <p style="color:#C00007; font-size:16px;">Not taking orders for delivery at this time.</p>
                                                <?php } ?>
                                                <?php /* ?><?php if($pickup_hours_from!='' && $pickup_hours_to!=''){
                                                  if(($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){
                                                  }else {
                                                  //err_msg
                                                  }
                                                  }?><?php */ ?>
                                                <?php
                                                if ($_REQUEST['err_msg'] == '1') {
                                                    ?>
                                                    <p style="color:#C00007; font-size:16px;">Coupon Discarded as minimum order amount not reached.</p>
            <?php
        }
        ?>
                                                <table width="100%" border="0" cellspacing="1" class="restro2_table" >
                                                    <tr>
                                                        <td height="20" colspan="3" align="center" class="restro2_table_bg"><h2>Qty</h2></td>
                                                        <td width="53%" height="20" align="center" class="restro2_table_bg"><h2>Item</h2></td>
                                                        <td width="24%" height="20" align="center" class="restro2_table_bg"><h2>Price</h2></td>
                                                    </tr>
                                                    <?php
                                                    $sql_restaurant_delivery_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id	 = '" . $_REQUEST['id'] . "'"));

                                                    $amount = 0;
                                                    $amt1 = 0;
                                                    while ($array_items = mysql_fetch_array($sql_items)) {
                                                        ?>
                                                        <tr>
                                                            <td height="30" colspan="3" align="center" class="text-center"><a href="#"><?php echo $array_items['quantity']; ?></a>
                                                                <div class="item_hover"> <a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&sub=sub&cart_id=<?php echo $array_items['id']; ?>">-</a> <a style="margin-left:23px;" href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&add=add&cart_id=<?php echo $array_items['id']; ?>">+</a> </div></td>
                                                            <td height="30" align="center"><?php
                                                    $sql_item_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '" . $array_items['menu_item_id'] . "'"));
                                                    echo $sql_item_name['menu_name'];
                                                        ?></td>
                                                            <td height="30" align="left" style="padding-left:2px;">$ <?php echo ($array_items['quantity'] * $array_items['price']); ?> <a href="delete_menu_cart_item.php?id=<?php echo $_REQUEST['id']; ?>&del_id=<?php echo $array_items['id']; ?>" onClick="return confirm('Are you sure?');"><img src="images/1400777057_delete.png" height="12" width="12"></a></td>
                                                        </tr>
                                                        <?php /* ?><tr class="item_hover">
                                                          <td width="8%" height="30" align="center"><a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&sub=sub&cart_id=<?php echo $array_items['id']; ?>">-</a></td>
                                                          <td width="8%" height="30" align="center">&nbsp;</td>
                                                          <td width="" height="30" align="center"><a style="margin-left:23px;" href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&add=add&cart_id=<?php echo $array_items['id']; ?>">+</a></td>
                                                          <td height="30" align="center"><a href="#">&nbsp;</a></td>
                                                          <td height="30" align="center"><a href="#">&nbsp;</a></td>
                                                          </tr><?php */ ?>
                                                        <?php
                                                        $amt1 = $amt1 + ($array_items['price'] * $array_items['quantity']);
                                                    }


                                                    $amount = ($amt1 - $_SESSION['coupon_discount' . $ses_rest_id] - $_SESSION['reward_point' . $ses_rest_id]);
                                                    //echo $_SESSION['coupon_discount'.$ses_rest_id];
                                                    ?>
        <?php if ($_SESSION['coupon_code' . $ses_rest_id] != '') { ?>
                                                        <tr id="discount_div" style="display:table-row;">
                                                            <td height="20" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
                                                            <td height="20" align="right" style="padding-top:20px;">Coupon Discount</td>
                                                            <td height="20" id="discount_td" align="left" style="padding-left:10px; padding-top:20px;"><?php echo "$ " . $_SESSION['coupon_discount' . $ses_rest_id]; ?></td>
                                                        </tr>
        <?php } ?>
        <?php if ($_SESSION['reward_point' . $ses_rest_id] != '') { ?>
                                                        <tr id="discount_reward_div" style="display:table-row;">
                                                            <td height="20" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
                                                            <td height="20" align="right" style="padding-top:20px;">Reward Point Discount</td>
                                                            <td height="20" id="discount_reward_td" align="left" style="padding-left:10px; padding-top:20px;"><?php echo "$ " . $_SESSION['reward_point' . $ses_rest_id]; ?></td>
                                                        </tr>
        <?php } ?>
                                                    <tr id="discount_div1" style="display:none;">
                                                        <td height="20" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
                                                        <td height="20" align="right" style="padding-top:20px;">Coupon Discount</td>
                                                        <td height="20" id="discount_td1" align="left" style="padding-left:10px; padding-top:20px;"></td>
                                                    </tr>
                                                    <tr id="discount_reward_div1" style="display:none;">
                                                        <td height="20" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
                                                        <td height="20" align="right" style="padding-top:20px;">Reward Point Discount</td>
                                                        <td height="20" id="discount_reward_td1" align="left" style="padding-left:10px; padding-top:20px;"></td>
                                                    </tr>
                                                    <tr class="total-tr">
                                                        <td height="20" colspan="3" align="center" >&nbsp;</td>
                                                        <td height="20" align="right" >Subtotal</td>
                                                        <td height="20" id="subtotal" align="left">$<?php echo $amount; ?></td>
                                                    </tr>
                                                    <tr class="total-tr">
                                                        <td height="20" colspan="3" align="center">&nbsp;</td>
                                                        <td height="20" align="right">Tax</td>
                                                        <td height="20" id="tax" align="left" style="padding-left:10px;"><?php
                                                            $tax = ($sql_restaurant_delivery_details['tax'] / 100 * $amount);
                                                            $tax1 = round($tax, 2);
                                                            echo "$ " . $tax1;
                                                            ?></td>
                                                    </tr>
        <?php if ($sql_restaurant_delivery_details['service_fee'] != '') { ?>
                                                        <tr>
                                                            <td height="20" colspan="3" align="center" width="32%">&nbsp;</td>
                                                            <td height="20" align="right">Service Fee </td>
                                                            <td height="20" align="left" style="padding-right:15px !important;"><?php echo "$ " . $sql_restaurant_delivery_details['service_fee']; ?></td>
                                                        </tr>
                                                <?php } ?>
                                                </table>
                                                <?php
                                                if (isset($_SESSION['del_charge' . $ses_rest_id])) {
                                                    $div_sty = 'block';
                                                } else {
                                                    $div_sty = 'none';
                                                }
                                                ?>
                                                <div id="del_crg_div" style="display:<?php echo $div_sty; ?>; position: relative; top: -11px;">
                                                    <table width="100%" border="0" cellspacing="1" class="restro2_table" >
        <?php if (isset($_SESSION['del_charge' . $ses_rest_id])) { ?>
                                                            <tr class="total-tr mn-ttl">
                                                                <td height="20" colspan="3" align="center" style="border-right: 1px solid #f8f8f8;">&nbsp;</td>
                                                                <td height="20" align="right" style="padding-left:114px !important;">Delivery Charge </td>
                                                                <td height="20" align="left" style="padding-left:10px;"><?php echo "$ " . $_SESSION['del_charge' . $ses_rest_id]; ?></td>
                                                            </tr>
                                                            <tr class="total-tr mn-ttl">
                                                                <td height="20" colspan="3" align="center" style="border-right: 1px solid #f8f8f8;">&nbsp;</td>
                                                                <td height="20" align="right" style="padding-left:114px !important;">Total </td>
                                                                <td height="20" align="left" style="padding-right:20px !important;"><?php echo "$ " . ($_SESSION['del_charge' . $ses_rest_id] + $tax1 + $amount + $sql_restaurant_delivery_details['service_fee']); ?></td>
                                                            </tr>
        <?php } else { ?>
                                                            <tr class="total-tr mn-ttl">
                                                                <td height="20" colspan="3" align="center" style="border-right: 1px solid #f8f8f8;">&nbsp;</td>
                                                                <td height="20" align="right" style="padding-left:94px !important;">Total </td>
                                                                <td height="20" align="left" style=""><?php echo "$ " . ($_SESSION['del_charge' . $ses_rest_id] + $tax1 + $amount + $sql_restaurant_delivery_details['service_fee']); ?></td>
                                                            </tr>
                                                <?php } ?>
                                                    </table>
                                                </div>
                                                <?php
                                                if (isset($_SESSION['del_charge' . $ses_rest_id])) {
                                                    $total_div = 'none';
                                                } else {
                                                    $total_div = 'block';
                                                }
                                                ?>
                                                <div id="total_div" style="display:<?php echo $total_div; ?>; position: relative; top: -11px;">
                                                    <table width="100%" border="0" cellspacing="1" class="restro2_table">
                                                        <tr class="total-tr mn-ttl">
                                                            <td height="20" colspan="3" align="center" style="border-right: 1px solid #f8f8f8;">&nbsp;</td>
                                                            <td height="20" align="right" style="padding-left:142px !important;">Total</td>
                                                            <td height="20" id="total" align="left" >$ <?php echo ($tax1 + $amount + $sql_restaurant_delivery_details['service_fee']); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <?php /* ?><?php echo $_SESSION['coupon_code']."<br>";
                                                  echo $_SESSION['coupon_discount']; ?><?php */ ?>
                                                <?php /* ?><h3 style="text-align:center;">Ready to order? </h3>
                                                  <?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){ $display_del1 = 'block'; $display_del2 = 'none'; }
                                                  else { $display_del1 = 'none'; $display_del2 = 'block'; }?>
                                                  <div class="restro2_delivery" style="background:#8099E9;display:<?php echo $display_del1; ?>;">
                                                  <a href="javascript:void(0);" style="cursor:default; color:#ffffff;"><p><h3>Want Delivery?</h3></p>
                                                  <?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){?>
                                                  <p style="color:#ffffff;">Add $<?php echo ($sql_restaurant_delivery_details['minimum_ammount'] - $amount); ?></p><?php } ?>
                                                  <p style="color:#ffffff;">Minimum $<?php echo $sql_restaurant_delivery_details['minimum_ammount']; ?></p></a>
                                                  </div>
                                                  <div class="restro2_delivery" style="background:#3C3C95; display:<?php echo $display_del2; ?>;">
                                                  <?php if(!isset($_SESSION['customer_id'])){ ?>
                                                  <a href="login.php" style="cursor:pointer; color:#ffffff;">
                                                  <?php 	} else { ?>
                                                  <a href="check_out.php?type=del" style="cursor:pointer; color:#ffffff;">
                                                  <?php } ?>
                                                  <p><h3>I Want Delivery!</h3></p>
                                                  <p style="color:#ffffff;">Delivery <?php if($sql_del_details['delivery_charge'] == ''){ echo "Free"; }
                                                  else{
                                                  echo "$".$sql_del_details['delivery_charge'];
                                                  }?></p>
                                                  <p style="color:#ffffff;">Total $<?php echo ($amount + $sql_del_details['delivery_charge']); ?></p></a>
                                                  </div>
                                                  <?php if($sql_del_details['pickup'] == 1){ $display_pickup = 'block'; } else { $display_pickup = 'none'; }?>
                                                  <div class="restro2_pick" style="display:<?php echo $display_pickup;?>">
                                                  <?php if(!isset($_SESSION['customer_id'])){ ?>
                                                  <a href="login.php">
                                                  <?php } else { ?>
                                                  <a href="check_out.php?type=pickup">
                                                  <?php } ?>
                                                  <p><h3>I'll pick it up</h3></p>
                                                  <p>Total $<?php echo $amount; ?></p></a>
                                                  </div><?php */ ?>
                                                <input type="hidden" id="resturant_id" value="<?php echo $_REQUEST['id']; ?>" />
                                                <input type="hidden" id="hid_coupon_code" value="<?php echo $_SESSION['coupon_code' . $ses_rest_id]; ?>" />
                                                <input type="hidden" id="hid_reward_point" value="<?php echo $_SESSION['user_reward_point' . $ses_rest_id]; ?>" />
                                                <input type="hidden" id="hid_coupon_discount" value="<?php echo $_SESSION['coupon_discount' . $ses_rest_id]; ?>" />
                                                <input type="hidden" id="hid_reward_discount" value="<?php echo $_SESSION['reward_point' . $ses_rest_id]; ?>" />
                                                <input type="hidden" id="hid_coupon_discount_ajax"  />
                                                <input type="hidden" id="hid_reward_discount_ajax" />
                                                <input type="hidden" name="ser_fee" id="ser_fee" value="<?php echo $sql_restaurant_delivery_details['service_fee']; ?>">
                                                <script type="text/javascript">



                                                    function change_coupon()
                                                    {
                                                        var $j = jQuery.noConflict();
                                                        //$j("#hide_show_span").show();
                                                        $j("#coupon_code").val('');
                                                        $j("#coupon_code").show(500);
                                                        $j("#apply").show(500);
                                                        $j("#coup_code").html('');
                                                    }


                                                    function check_coupon_session()
                                                    {
                                                        var $j = jQuery.noConflict();
                                                        var cn_msg = "'Are you sure you want to Delete This Coupon!!'";
                                                        var id = $j("#resturant_id").val();
                                                        var coupon_code = $j("#hid_coupon_code").val();
                                                        $j("#hide_show_span").hide();
                                                        $j("#coupon_code").hide(500);
                                                        $j("#apply").hide(500);
                                                        $j("#coupon_text").show();
                                                        $j("#code").html(coupon_code);
                                                        $j("#apply_coupon").show();
                                                        $j("#code").show();
                                                        $j("#coup_code").html('<a href ="javascript:void(0);" onclick="change_coupon()"><img src="images/change-coupon.png" height="12" title="Change Coupon Code" width="12"></a><a href ="remove_coupon.php?id=' + id + '" onclick="return confirm(' + cn_msg + ');" ><img src="images/1400777057_delete.png" height="12" title="Remove Coupon" width="12"> </a>');
                                                    }



                                                </script> 
                                                <script type="text/javascript">

                                                    function check_coupon_code(amount, res_id) {
                                                        var $j = jQuery.noConflict();
                                                        var id = $j("#resturant_id").val();
                                                        var reward_discount = $j("#hid_reward_discount").val();
                                                        var reward_discount_ajax = $j("#hid_reward_discount_ajax").val();
                                                        var coupon_code = $j("#coupon_code").val();
                                                        $j.ajax({
                                                            url: 'coupon_ajax.php',
                                                            type: 'POST',
                                                            data: 'amount=' + amount + '&res_id=' + res_id + '&coupon_code=' + coupon_code + '&reward_discount=' + reward_discount + '&reward_discount_ajax=' + reward_discount_ajax,
                                                            //dataType : 'json',
                                                            beforeSend: function (jqXHR, settings) {
                                                                //alert(url);
                                                            },
                                                            success: function (data, textStatus, jqXHR) {
                                                                //alert(data);
                                                                if (data == 'Expired' || data == 'Minimum' || data == 'Invalid' || data == 'Offline') {

                                                                    if (data == 'Expired') {
                                                                        var err_msg = 'The Coupon has Expired.';
                                                                    } else if (data == 'Minimum') {
                                                                        var err_msg = 'Minimum order amount for this coupon has not reached. ';
                                                                    } else if (data == 'Invalid') {
                                                                        var err_msg = 'Invalid Coupon Code';
                                                                    } else if (data == 'Offline') {
                                                                        var err_msg = 'This coupon is not redeemable online for pickup or delivery.';
                                                                    }

                                                                    $j("#error_msg").html(err_msg);
                                                                    $j("#error_msg").slideDown(1000);
                                                                    $j("#discount_div1").slideUp(500);
                                                                    $j("#subtotal").html('$ ' +<?php echo $amount; ?>);
                                                                    $j("#total").html('$' +<?php echo ($tax1 + $amount); ?>);
                                                                    $j("#coupon_code").val('');
                                                                    $j("#coupon_text").hide();
                                                                    $j("#coup_code").html('');
                                                                    $j("#code").html('');
                                                                    $j("#code").hide(500);
                                                                } else {
                                                                    var cn_msg = "'Are you sure you want to Delete This Coupon!!'";
                                                                    $j("#error_msg").slideUp(1000);
                                                                    var price = data.split('^');
                                                                    //alert(price[0]);
                                                                    //alert(price[1]);

                                                                    var display_attr = $j("#discount_div").css('display');
                                                                    if (display_attr == 'table-row')
                                                                    {
                                                                        $j("#discount_div").hide();
                                                                    }

                                                                    $j("#discount_td1").html('$ ' + price[1]);
                                                                    $j("#hid_coupon_discount_ajax").val(price[1]);
                                                                    $j("#discount_div1").slideDown(1000);
                                                                    var tax = parseFloat('<?php echo $sql_restaurant_delivery_details['tax'] ?>') / parseInt(100);
                                                                    var service_fee = $j("#ser_fee").val();
                                                                    if (service_fee == '') {
                                                                        var ser_fee = 0.00;
                                                                    } else {
                                                                        var ser_fee = service_fee;
                                                                    }

                                                                    var new_tax = parseFloat(tax) * parseFloat(price[0]);
                                                                    var final_tax = new_tax;
                                                                    var coupon_discount = price[1];
                                                                    $j("#tax").html('$ ' + (final_tax.toFixed(2)));
                                                                    var with_tax = (parseFloat(final_tax) + parseFloat(price[0]) + parseFloat(ser_fee));
                                                                    var total_amount = with_tax.toFixed(2);
                                                                    $j("#subtotal").html('$ ' + price[0]);
                                                                    $j("#total").html('$ ' + total_amount);
                                                                    $j("#hide_show_span").show();
                                                                    $j("#coupon_code").hide(500);
                                                                    $j("#apply").hide(500);
                                                                    $j("#hide_show_span").hide();
                                                                    $j("#coupon_text").show();
                                                                    $j("#code").html(coupon_code);
                                                                    $j("#code").show(500);
                                                                    $j("#coup_code").html(' <a href ="javascript:void(0);" onclick="change_coupon()"><img src="images/change-coupon.png" height="12" title="Change Coupon Code" width="12"></a>   <a href ="remove_coupon.php?id=' + id + '" onclick="return confirm(' + cn_msg + ');" ><img src="images/1400777057_delete.png" height="12" title="Remove Coupon" width="12"> </a>');
                                                                }
                                                            },
                                                            /*complete : function(jqXHR, textStatus){
                                                             alert(3);
                                                             },*/
                                                            error: function (jqXHR, textStatus, errorThrown) {
                                                            }
                                                        });
                                                    }

                                                    function open_reward_div()
                                                    {
                                                        var $j = jQuery.noConflict();
                                                        $j("#apply_reward").slideToggle(1000);
                                                        $j("#reward_div").toggle();
                                                    }

                                                    function open_apply_div()
                                                    {
                                                        var $j = jQuery.noConflict();
                                                        $j("#apply_coupon").slideToggle();
                                                    }

                                                </script> 
                                                <script type="text/javascript">

                                                    function check_reward_point()
                                                    {
                                                        var $j = jQuery.noConflict();
                                                        var reward_point = $j("#reward_point").val();
                                                        var acc_reward_point = $j("#acc_reward").val();
                                                        if (reward_point > acc_reward_point)
                                                        {
                                                            alert("You dont have this much point.");
                                                            $j("#reward_point").val('');
                                                            $j("#reward_point").focus();
                                                        }

                                                    }

                                                    /*function check_null(){
                                                     var $j = jQuery.noConflict();
                                                     if($j("#reward_point").val() == '')
                                                     {
                                                     alert("This Field cannot be left Blank!!");
                                                     $j("#reward_point").focus();
                                                     return false;
                                                     }
                                                     }*/



                                                    function check_percent()
                                                    {
                                                        var $j = jQuery.noConflict();
                                                        var reward_point = $j("#reward_point").val();
                                                        if (reward_point > 99)
                                                        {
                                                            alert('You cannot redeem more than 99 points at a time !!');
                                                            $j("#reward_point").val('');
                                                            $j("#reward_point").focus();
                                                        }

                                                    }




                                                    function get_reward_point(amount, res_id) {

                                                        var $j = jQuery.noConflict();
                                                        if ($j("#reward_point").val() == '')
                                                        {
                                                            alert("This Field cannot be left Blank!!");
                                                            $j("#reward_point").focus();
                                                            return false;
                                                        } else {

                                                            var reward_point = $j("#reward_point").val();
                                                            var coupon_discount = $j("#hid_coupon_discount").val();
                                                            var coupon_discount_ajax = $j("#hid_coupon_discount_ajax").val();
                                                            var id = $j("#resturant_id").val();
                                                            $j.ajax({
                                                                url: 'reward_ajax.php',
                                                                type: 'POST',
                                                                data: 'reward_point=' + reward_point + '&res_id=' + res_id + '&amount=' + amount + '&coupon_discount=' + coupon_discount + '&coupon_discount_ajax=' + coupon_discount_ajax,
                                                                //dataType : 'json',
                                                                beforeSend: function (jqXHR, settings) {
                                                                    //alert(url);
                                                                },
                                                                success: function (data, textStatus, jqXHR) {
                                                                    var price = data.split('^');
                                                                    var display_attr = $j("#discount_div").css('display');
                                                                    if (display_attr == 'table-row')
                                                                    {
                                                                        $j("#discount_reward_div").hide();
                                                                    }

                                                                    //var final_disc = price[1].toFixed(2);


                                                                    $j("#discount_reward_div").hide();
                                                                    $j("#discount_reward_td1").html('$ ' + price[1]);
                                                                    $j("#hid_reward_discount_ajax").val(price[1]);
                                                                    $j("#discount_reward_div1").slideDown(1000);
                                                                    var tax = parseFloat('<?php echo $sql_restaurant_delivery_details['tax'] ?>') / parseInt(100);
                                                                    var service_fee = $j("#ser_fee").val();
                                                                    if (service_fee == '') {
                                                                        var ser_fee = 0.00;
                                                                    } else {
                                                                        var ser_fee = service_fee;
                                                                    }

                                                                    var new_tax = parseFloat(tax) * parseFloat(price[0]);
                                                                    var final_tax = new_tax;
                                                                    $j("#tax").html('$ ' + (final_tax.toFixed(2)));
                                                                    var with_tax = parseFloat(final_tax) + parseFloat(price[0]) + parseFloat(ser_fee);
                                                                    var total_amount = with_tax.toFixed(2);
                                                                    //alert(with_tax);

                                                                    var cn_msg = "'Are you sure you want to Delete This Reward Point From Subtotal!!'";
                                                                    $j("#subtotal").html('$ ' + price[0]);
                                                                    $j("#total").html('$ ' + total_amount);
                                                                    $j("#reward_show_span").hide(500);
                                                                    $j("#reward_div").hide(500);
                                                                    $j("#reward_text").show(500);
                                                                    $j("#reward").html(reward_point);
                                                                    $j("#reward").show(500);
                                                                    $j("#reward_point_span").html('<a href ="javascript:void(0);" onclick="change_reward()"><img src="images/change-coupon.png" height="12" title="Change Reward Point" width="12"></a><a href ="remove_reward.php?id=' + id + '" onclick="return confirm(' + cn_msg + ');" ><img src="images/1400777057_delete.png" height="12" title="Remove Reward" width="12"> </a>');
                                                                },
                                                                /*complete : function(jqXHR, textStatus){
                                                                 alert(3);
                                                                 },*/
                                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                }
                                                            });
                                                        }




                                                    }

                                                    function change_reward()
                                                    {
                                                        //$j("#reward_text").hide();
                                                        //$j("#reward").hide();
                                                        //$j("#reward_show_span").show();
                                                        $j("#reward_point").val('');
                                                        $j("#reward_div").show(500);
                                                        $j("#reward_point_span").html('');
                                                    }

                                                    function check_reward_session()
                                                    {
                                                        var cn_msg = "'Are you sure you want to Delete This Reward Point From Subtotal!!'";
                                                        var id = $j("#resturant_id").val();
                                                        var reward_point = $j("#hid_reward_point").val();
                                                        $j("#reward_show_span").hide(500);
                                                        $j("#reward_div").hide(500);
                                                        $j("#reward_text").show(500);
                                                        $j("#apply_reward").show(500);
                                                        $j("#reward").html(reward_point);
                                                        $j("#reward").show(500);
                                                        $j("#reward_point_span").html('<a href ="javascript:void(0);" onclick="change_reward()"><img src="images/change-coupon.png" height="12" title="Change Reward Point" width="12"></a><a href ="remove_reward.php?id=' + id + '" onclick="return confirm(' + cn_msg + ');" ><img src="images/1400777057_delete.png" height="12" title="Remove Reward" width="12"> </a>');
                                                    }
                                                </script>
                                                <?php
                                                $res_id = $_GET['id'];
                                                ?>
                                                <form name="order_del_frm" method="post" action="">
                                                    <label class="coupon-check-label">
                                                        <div id="hide_show_span">
                                                            <input type="checkbox"  id="have_coupon" name="have_coupon" onClick="open_apply_div();"  class="regular-checkbox big-checkbox" />
                                                            <label for="have_coupon"></label>
                                                            <!--<input type="checkbox" id="have_coupon" name="have_coupon" onClick="open_apply_div();" >--> I have a Coupon Code</div>
                                                    </label>
                                                    <div id="apply_coupon" class="cpn" style="display:none;">
                                                        <div class="left lower-code-row"> <!--style="width: 100%; margin: -3px 0px 13px; font-size: 19px; text-align:left;"--> 
                                                            <span id="coupon_text" style="display:none;">Coupon Code : </span> <span id="code" class="cupon-code" style="display:none;"></span> <span id="coup_code" class="cupon-action"> </span> </div>
                                                        <div class="left" style="width:100%;">
                                                            <input type="text" name="coupon_code" id="coupon_code" class="profilefield_right" style="float:left; width:154px;  padding:2px 5px; margin:0;">
                                                            <!--margin-right:11px;-->

                                                            <input type="button" name="apply" class="check_order_button" id="apply" onClick="check_coupon_code('<?php echo $amt1; ?>', '<?php echo $res_id; ?>');" value="Apply" style="text-decoration:none; margin:0;  padding:5px 22px;">
                                                            <!-- margin-top:10px;--> 
                                                        </div>
                                                    </div>
                                                    <div id="error_msg" style="color:#F00;  display:none;"></div>
                                                    <div class="clear:both;"></div>
                                                    <?php
                                                    $sql_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = 1"));
                                                    $sql_cust_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '" . $_SESSION['customer_id'] . "'"));

                                                    if ($sql_reward_point['minimum_reward_point'] <= $sql_cust_reward_point['reward_point']) {
                                                        ?>
                                                        <label class="coupon-check-label">
                                                            <div id="reward_show_span">
                                                                <input type="checkbox"  id="have_reward"  name="have_reward" onClick="open_reward_div();"  class="regular-checkbox big-checkbox" />
                                                                <label for="have_reward"></label>
                                                                <!--<input type="checkbox" id="have_reward" name="have_reward" onClick="open_reward_div();" >--> I want to use my Reward Points</div>
                                                        </label>
                                                        <div id="apply_reward" class="cpn" style="display:none;">
                                                            <div class="left lower-code-row mrgn-btn-sm"> <span id="reward_text" style="display:none;">Reward Redeemed : </span> <span id="reward" class="cupon-code sm" style="display:none;"></span> <span id="reward_point_span" class="cupon-action"> </span> </div>
                                                            <div class="left" style="width:100%;">
                                                                <input type="hidden" name="acc_reward" id="acc_reward" value="<?php echo $sql_cust_reward_point['reward_point']; ?>" />
                                                                <div id="reward_div" style="display:none;">
                                                                    <input type="text" name="reward_point" id="reward_point" onBlur="check_reward_point();" class="profilefield_right" style="float:left; width:154px;  padding:5px; margin:0; margin-top:9px;" onKeyPress="return goodchars(event, '1234567890');" onKeyUp="check_percent();">
                                                                    <input type="button" class="check_order_button" name="reward_point_submit" value="Apply" onClick=" return get_reward_point('<?php echo $amt1; ?>', '<?php echo $res_id; ?>');" style="text-decoration: none; margin-top: 10px; margin-left: -1px; padding: 5px 22px;" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear:both;"></div>
                                                        <?php
                                                    }


                                                    if ($Pickup_available != 'Available') {
                                                        $class_pickup = "disabled";
                                                    } else {
                                                        $class_pickup = "checked";
                                                    }
                                                    ?>
                                                    <?php if ($sql_restaurant_delivery_details['pickup'] == 1) { ?>
                                                        <input type="radio" name="delivery_type" value="pickup" style="margin-right:5px;" id="pickup" <?php echo $class_pickup; ?> onClick="return del_type(this.value);">
                                                        <span style="margin-right:50px;">PICKUP &nbsp;<img src="images/pickup.png" align="absmiddle"> </span>
                                                    <?php } ?>
                                                    <?php /* ?><?php if(($sql_restaurant_delivery_details['minimum_ammount'] > $amount) || ($time1 <$del_hours_from  || $time1 >$del_hours_to)){
                                                      $class_del = "disabled"; } ?><?php */ ?>
                                                    <?php /* ?><?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){
                                                      $class_del = "disabled";
                                                      }else if(($time1 <$del_hours_from  || $time1 >$del_hours_to)){
                                                      $class_del = "disabled";
                                                      }?><?php */ ?>
                                                    <?php
                                                    if ($sql_restaurant_delivery_details['minimum_ammount'] > $amount) {
                                                        $class_del = "disabled";
                                                    } elseif ($_REQUEST['type'] == 'del' && isset($_SESSION['del_charge' . $ses_rest_id])) {
                                                        $class_del = 'checked';
                                                    } elseif ($Delivery_available != 'Available') {
                                                        $class_del = "disabled";
                                                    } else {
                                                        $class_del = "checked";
                                                    }
                                                    ?>
                                                    <?php if ($sql_restaurant_delivery_details['delivery'] == 1) { ?>
                                                        <input type="radio" name="delivery_type" value="del" style="margin-right:5px;" id="del" <?php echo $class_del; ?> onClick="return del_type(this.value);">
                                                        <span>DELIVERY &nbsp;<img src="images/delivery.png" align="absmiddle"></span>
                                                    <?php } ?>
                                                    <?php if (isset($_SESSION['del_charge' . $ses_rest_id])) { ?>
                                                        <div id="change_del_add"><a href="#top_div" onClick="del_block();" class="chg_del_add">Change Delivery Address</a></div>
                                                    <?php } ?>
                                                    <?php if ($sql_restaurant_delivery_details['minimum_ammount'] != '') { ?>
                                                        <p>Delivery Minimum : $ <?php echo $sql_restaurant_delivery_details['minimum_ammount']; ?> (Before tax)</p>
        <?php } ?>
                                                    <p>No minimum on pickup orders</p>
                                                    <br>
                                                    <script type="text/javascript">
                                                        var $j = jQuery.noConflict();
                                                        function del_type(val) {
                                                            if (val == 'pickup') {
                                                                $j('#check_out_pickup').slideDown(1000);
                                                                $j('#check_out_del').slideUp(1000);
                                                                $j('#del_crg_div').slideUp(1000);
                                                                $j('#total_div').slideDown(1000);
                                                                $j('#change_del_add').slideUp(1000);
                                                                /*document.getElementById('check_out_pickup').style.display = 'block';
                                                                 document.getElementById('check_out_del').style.display = 'none';
                                                                 document.getElementById('del_crg_div').style.display = 'none';
                                                                 document.getElementById('total_div').style.display = ' block';
                                                                 document.getElementById('change_del_add').style.display = 'none';*/
                                                            }
                                                            else if (val == 'del') {
                                                                $j('#check_out_pickup').slideUp(1000);
                                                                $j('#check_out_del').slideDown(1000);
                                                                $j('#del_crg_div').slideDown(1000);
                                                                $j('#total_div').slideUp(1000);
                                                                $j('#change_del_add').slideDown(1000);
                                                                /*document.getElementById('check_out_pickup').style.display = 'none';
                                                                 document.getElementById('check_out_del').style.display = 'block';
                                                                 document.getElementById('del_crg_div').style.display = 'block';
                                                                 document.getElementById('total_div').style.display = 'none';
                                                                 document.getElementById('change_del_add').style.display = 'block';*/
                                                            }
                                                        }
                                                    </script> 
                                                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script> 
                                                    <script>

                                                        function initialize() {

                                                            var markers = [];
                                                            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                                                            });
                                                            var input = (
                                                                    document.getElementById('address'));
                                                            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                                                            var searchBox = new google.maps.places.SearchBox(
                                                                    (input));
                                                            google.maps.event.addListener(searchBox, 'places_changed', function () {
                                                                var places = searchBox.getPlaces();
                                                                if (places.length == 0) {
                                                                    return;
                                                                }

                                                            });
                                                            google.maps.event.addListener(map, 'bounds_changed', function () {
                                                                var bounds = map.getBounds();
                                                                searchBox.setBounds(bounds);
                                                            });
                                                        }

                                                        google.maps.event.addDomListener(window, 'load', initialize);</script>
                                                    <?php
                                                    if (!isset($_SESSION['customer_id'])) {
                                                        $link = 'login.php';
                                                    } else {
                                                        $link = 'check_out.php?type=pickup';
                                                    }
                                                    ?>
                                                    <?php
                                                    //if(($current_time1 > $time11 && $current_time1 < $time22))
                                                    if ($restaurant_status == 'open') {
                                                        if ($sql_restaurant_delivery_details['pickup'] == 1 || $sql_restaurant_delivery_details['delivery'] == 1) {
                                                            ?>
                                                            <div id="check_out_pickup">
                                                                <?php
                                                                if ($open != '') {
                                                                    //if(($time1 >$del_hours_from  && $time1 <$del_hours_to && $sql_restaurant_delivery_details['minimum_ammount'] < $amount) || ($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){ 
                                                                    ?>
                                                                    <a href="<?php echo $link; ?>" class="check_order_button" style="text-decoration: none; padding: 5px 50px; float: left; margin-left: 28%;"> Check Out </a>
                                                                    <?php
                                                                    //} 
                                                                } else {
                                                                    ?>
                                                                    <a href="<?php echo $link; ?>" class="check_order_button" style="text-decoration: none; padding: 5px 50px; float: left; margin-left: 28%;"> Check Out </a>
                                                            <?php } ?>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    if (!isset($_SESSION['customer_id'])) {
                                                        $link1 = 'login.php';
                                                    } else {
                                                        $link1 = 'check_out.php?type=del';
                                                    }
                                                    ?>
                                                    <?php
                                                    //if(($current_time1 > $time11 && $current_time1 < $time22))
                                                    if ($restaurant_status == 'open') {
                                                        if ($sql_restaurant_delivery_details['pickup'] == 1 || $sql_restaurant_delivery_details['delivery'] == 1 || isset($_SESSION['del_charge' . $ses_rest_id])) {
                                                            ?>
                                                            <div id="check_out_del" style="display:none;">
                                                                <?php
                                                                if (isset($_SESSION['del_charge' . $ses_rest_id]) && !isset($_SESSION['customer_id'])) {
                                                                    $link3 = 'login.php?type=del';
                                                                } elseif (isset($_SESSION['del_charge' . $ses_rest_id]) && isset($_SESSION['customer_id'])) {
                                                                    $link3 = 'check_out.php?type=del';
                                                                } else {
                                                                    $link3 = '#top_div';
                                                                }
                                                                ?>
                                                                <a href="<?php echo $link3; ?>" onClick="del_block();" class="check_order_button" style="text-decoration: none; padding: 5px 50px; float: left; margin-left: 28%;">Check Out </a>
                                                                <?php /* ?><?php if($del_hours_from!='' && $del_hours_to!='' && $pickup_hours_from!='' && $pickup_hours_to!=''){
                                                                  if(($time1 >$del_hours_from  && $time1 <$del_hours_to && $sql_restaurant_delivery_details['minimum_ammount'] < $amount) || ($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){ ?>
                                                                  <a href="<?php echo $link1; ?>" class="check_order_button" style="text-decoration:none; margin-left:50px; margin-top:10px; padding:5px 50px;"> Check Out </a>
                                                                  <?php } }else{ ?>
                                                                  <a href="<?php echo $link1; ?>" class="check_order_button" style="text-decoration:none; margin-left:50px; margin-top:10px; padding:5px 50px;"> Check Out </a>
                                                                  <?php } ?><?php */ ?>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </form>
                                                <form name="frm" method="post" action="">
                                                    <div class="pop_item2" style="display:none;" id="del_add">
                                                        <h2>Where are you?<a href="Javascript:void(0);" onClick="closedel_add()" style="margin-left:425px;"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                                        <h3>We want to make sure this restaurant is convenient for delivery or pickup.</h3>
                                                        <h3>Please enter your address </h3>
                                                        <input name="address" id="address" type="text" class="pop_quantity" style="width:350px; margin:10px !important; font-family: Calibri !important; font-size:14px;" placeholder="Enter Address" />
                                                        <div id="map-canvas"></div>
                                                        <div>
                                                            <input name="submit" id="submit" type="submit" value="VERIFY ADDRESS" class="pop_button" style="width:150px;" />
                                                        </div>
                                                    </div>
                                                </form>
                                                <div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>

                                        <!-------------------------------------- SINGLE CART --------------------------------------->
                                        <?php
                                    }
									?>
                                    <div id="stopHere_single_cart"></div>
                                    <?php
                                } else {
                                    ?>

                                    <!-----------------------------------  GROUP CART  ------------------------------------------> 
                                    
                                    <?php
                                    $restaurant_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $_REQUEST['id'] . "'"));
                                    $sql_restaurant_delivery_details1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id	 = '" . $_REQUEST['id'] . "'"));
                                    ?>
                                    <?php if ($_REQUEST['del_item_succ'] == '1') { ?>
                                        <p>Item Deleted Successfully.</p>
                                    <?php } ?>
                                    <?php if ($_REQUEST['qty_upd_succ'] == '1') { ?>
                                        <p>Item Updated Successfully.</p>
    <?php } ?>
                                    <div id="group_cart" class="follow-scroll">
                                        <div id="cart_rest_name"><?php echo stripslashes($restaurant_basic_info['restaurant_name']); ?></div>
                                        <div class="cart_th f_clear">
                                            <div class="cart_td cart_td1">Item</div>
                                            <div class="cart_td cart_td2">Qty</div>
                                            <div class="cart_td cart_td3">Price</div>
                                        </div>
                                        <div id="cart_container">
                                            <?php
                                            $sql_sel_groups = mysql_query("SELECT t1.* FROM restaurant_group_order_details as t1  INNER JOIN restaurant_group_order as t2 ON t2.id = t1.group_order_id  WHERE t1.group_order_id = '" . $_SESSION['group_order_id' . $ses_rest_id] . "' AND t2.restaurant_id = '" . $_REQUEST['id'] . "'  ");
                                            $total_tax = 0;
                                            $total_sub_total = 0;
                                            $grand_total = 0;
                                            $total_del_charge = 0;
                                            $coupon_diss = 0;
                                            $reward_point_dis = 0;
                                            $service_fee = 0;
                                            while ($array_sel_groups = mysql_fetch_array($sql_sel_groups)) {
                                                ?>
                                                <div class="fcart myitems ordering">
                                                    <div title="<?php echo $array_sel_groups['name']; ?>" class="friend-name">
                                                        <div class="friend-name-cont text_dots"> <span style="color: #790000;"> <span class="role">
                                                                    <?php if ($array_sel_groups['is_admin'] == '1') { ?>
                                                                        <img src="images/icon_admin.png" class="head_admin">
                                                                    <?php } ?>
                                                                    <img src="images/user_img.png" width="20" height="20" class="user_pic">
                                                                <?php if ($array_sel_groups['is_admin'] == '1') { ?>
                                                                        (Admin)</span>
                                                    <?php } ?>
                                                            </span> <?php echo $array_sel_groups['name']; ?> </div>
                                                    </div>
                                                    <?php
                                                    $sql_sel_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE group_id = '" . $_SESSION['group_order_id' . $ses_rest_id] . "' AND group_order_details_id = '" . $array_sel_groups['id'] . "' AND restaurant_id = '" . $_REQUEST['id'] . "' ");
                                                    if (mysql_num_rows($sql_sel_items) > 0) {
                                                        $total_amt = 0;
                                                        while ($array_sel_items = mysql_fetch_array($sql_sel_items)) {
                                                            ?>
                                                            <div class="items">
                                                                <div>
                                                                    <div class="cart_tr edit_item cart_edit">
                                                                        <div class="cart_item f_clear">
                                                                            <div class="cart_td cart_td1 text_dots">
                                                                                <p>
                                                                                    <?php
                                                                                    $sql_item_name1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '" . $array_sel_items['menu_item_id'] . "'"));
                                                                                    echo $sql_item_name1['menu_name'];
                                                                                    ?>
                                                                                </p>
                                                                            </div>
                                                                            <div class="cart_td cart_td2">
                                                                                <?php if ($array_sel_groups['id'] == $_SESSION['group_order_details_id' . $ses_rest_id]) { ?>
                                                                                    <a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&menu_del_id=<?php echo $array_sel_items['id']; ?>&sub_item=sub">-</a>
                                                                                <?php } ?>
                                                                                <?php echo $array_sel_items['quantity']; ?>
                                                                                <?php if ($array_sel_groups['id'] == $_SESSION['group_order_details_id' . $ses_rest_id]) { ?>
                                                                                    <a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&menu_del_id=<?php echo $array_sel_items['id']; ?>&add_item=add">+</a>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <div class="cart_td cart_td3"> <span class="itm_price">$<?php echo ($array_sel_items['quantity'] * $array_sel_items['price']); ?></span>
                                                                                <?php if ($array_sel_groups['id'] == $_SESSION['group_order_details_id' . $ses_rest_id]) { ?>
                                                                                    <span><a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&menu_del_id=<?php echo $array_sel_items['id']; ?>&delete_item=delete" onClick="return confirm('Are you sure , you want to delete this item?');"><img src="images/1400777057_delete.png" height="12" width="12"></a></span>
                                                                        <?php } ?>
                                                                            </div>
                                                                        </div>
                <?php /* ?><div class="cart_item_note"><b>Flavor</b>:  Cherry</div><?php */ ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $total_amt = $total_amt + ($array_sel_items['quantity'] * $array_sel_items['price']);
                                                            $total_aft_coupon_dis = ($total_amt - $_SESSION['coupon_discount' . $ses_rest_id . "_" . $array_sel_groups['id']] - $_SESSION['reward_point' . $ses_rest_id . "_" . $array_sel_groups['id']]);
                                                        }
                                                        ?>
                                                        <?php if ($array_sel_groups['done_status'] == '1') { ?>
                                                            <div class="user_status_done"></div>
                                                        <?php } else { ?>
                                                            <div class="user_status"></div>
                                                        <?php } ?>
                                                        <?php
                                                        if ($_SESSION['coupon_code' . $ses_rest_id . "_" . $array_sel_groups['id']] != '') {
                                                            ?>
                                                            <div class="left lower-code-row"> <span id="coupon_text" style="display: inline;">Coupon Code : </span> <span id="code" class="cupon-code" style="display: inline-block;"><?php echo $_SESSION['coupon_code' . $ses_rest_id . "_" . $array_sel_groups['id']]; ?></span> <span id="coup_code_group" class="cupon-action"><a href="javascript:void(0);" onClick="change_group_coupon()"><img src="images/change-coupon.png" height="12" title="Change Coupon Code" width="12"></a><a href="remove_coupon_group.php?id=<?php echo $_REQUEST['id']; ?>" onClick="return confirm('Are you sure you want to Delete This Coupon!!');"><img src="images/1400777057_delete.png" height="12" title="Remove Coupon" width="12"> </a></span> </div>
                                                        <?php } ?>
            <?php if ($array_sel_groups['id'] == $_SESSION['group_order_details_id' . $ses_rest_id]) { ?>
                <?php if ($_SESSION['coupon_code' . $ses_rest_id . "_" . $array_sel_groups['id']] == '') { ?>
                                                                <label class="coupon-check-label">
                                                                    <div id="hide_show_span">
                                                                        <input type="checkbox" id="have_coupon_grp" name="have_coupon_grp" onClick="open_grp_apply_coupon();" class="regular-checkbox big-checkbox">
                                                                        <label for="have_coupon_grp"></label>
                                                                        I have a Coupon Code</div>
                                                                </label>
                <?php } ?>
                                                            <div id="apply_coupon_grp" class="cpn" style="display:none;">
                                                                <div class="left lower-code-row"> <span id="coupon_text" style="display:none;">Coupon Code : </span> </div>
                                                                <div class="left" style="width:100%; margin: 0 0 8px 0;">
                                                                    <input type="text" name="coupon_code_grp" id="coupon_code_grp" class="profilefield_right" style="float:left; width:166px;  padding:5px; margin:0 10px 0 0;">
                                                                    <input type="button" name="apply" class="check_order_button" id="apply" value="Apply" onClick="check_group_coupon_code('<?php echo $total_amt; ?>', '<?php echo $_REQUEST['id']; ?>');" style="text-decoration:none; margin:0;  padding:8px 20px;">
                                                                </div>
                                                                <div id="error_msg" style="color: rgb(255, 0, 0); text-align:left; display:none;"></div>
                                                            </div>
                                                            <script>
                                                                function change_group_coupon() {
                                                                    var $j = jQuery.noConflict();
                                                                    $j("#apply_coupon_grp").slideDown(1000);
                                                                    $j("#coup_code_group").hide(1000);
                                                                }

                                                                function open_grp_apply_coupon() {
                                                                    var $j = jQuery.noConflict();
                                                                    if ($j('input[name="have_coupon_grp"]').prop("checked") == true) {
                                                                        $j("#apply_coupon_grp").slideDown(1000);
                                                                    } else {
                                                                        $j("#apply_coupon_grp").slideUp(1000);
                                                                    }

                                                                }

                                                                function check_group_coupon_code(amount, res_id) {
                                                                    var $j = jQuery.noConflict();
                                                                    var coupon_code = $j("#coupon_code_grp").val();
                                                                    $j.ajax({
                                                                        url: 'coupon_ajax_group.php',
                                                                        type: 'POST',
                                                                        data: 'amount=' + amount + '&res_id=' + res_id + '&coupon_code=' + coupon_code,
                                                                        //dataType : 'json',
                                                                        beforeSend: function (jqXHR, settings) {
                                                                            //alert(url);
                                                                        },
                                                                        success: function (data, textStatus, jqXHR) {
                                                                            //alert(data);
                                                                            if (data == 'Expired' || data == 'Minimum' || data == 'Invalid' || data == 'Offline') {

                                                                                if (data == 'Expired') {
                                                                                    var err_msg = 'The Coupon has Expired.';
                                                                                } else if (data == 'Minimum') {
                                                                                    var err_msg = 'Minimum order amount for this coupon has not reached. ';
                                                                                } else if (data == 'Invalid') {
                                                                                    var err_msg = 'Invalid Coupon Code';
                                                                                } else if (data == 'Offline') {
                                                                                    var err_msg = 'This coupon is not redeemable online for pickup or delivery.';
                                                                                }

                                                                                $j("#error_msg").html(err_msg);
                                                                                $j("#error_msg").slideDown(1000);
                                                                                /*$j("#discount_div1").slideUp(500);
                                                                                 $j("#subtotal").html('$ '+<?php echo $amount; ?>);
                                                                                 $j("#total").html('$' +<?php echo ($tax1 + $amount); ?>);
                                                                                 $j("#coupon_code").val('');
                                                                                 $j("#coupon_text").hide();
                                                                                 $j("#coup_code").html('');
                                                                                 $j("#code").html('');
                                                                                 $j("#code").hide(500);*/

                                                                            } else {
                                                                                window.location.href = "https://foodandmenu.com/restaurant.php?id=" + res_id;
                                                                            }
                                                                        },
                                                                        /*complete : function(jqXHR, textStatus){
                                                                         alert(3);
                                                                         },*/
                                                                        error: function (jqXHR, textStatus, errorThrown) {
                                                                        }

                                                                    });
                                                                }

                                                            </script>
                                                        <?php } ?>
                                                        <?php if ($_SESSION['customer_id'] != '') { ?>
                                                            <?php if ($_SESSION['user_reward_point' . $ses_rest_id . '_' . $array_sel_groups['id']] != '') { ?>
                                                                <div class="left lower-code-row mrgn-btn-sm"> <span id="reward_text">Reward Redeemed : </span> <span id="reward" class="cupon-code sm"><?php echo $_SESSION['user_reward_point' . $ses_rest_id . '_' . $_SESSION['group_order_details_id' . $ses_rest_id]]; ?></span> <span id="reward_point_span_group_<?php echo $array_sel_groups['id']; ?>" class="cupon-action"><a href="javascript:void(0);" onClick="change_group_reward('<?php echo $array_sel_groups['id']; ?>')"><img src="images/change-coupon.png" height="12" title="Change Reward Point" width="12"></a><a href="remove_reward_group.php?id=<?php echo $_REQUEST['id']; ?>" onClick="return confirm('Are you sure you want to Delete This Reward Point From Subtotal!!');"><img src="images/1400777057_delete.png" height="12" title="Remove Reward" width="12"> </a></span> </div>
                                                            <?php } ?>
                                                            <?php
                                                            if ($_SESSION['customer_id'] != '') {
                                                                if ($array_sel_groups['id'] == $_SESSION['group_order_details_id' . $ses_rest_id]) {
                                                                    if ($_SESSION['user_reward_point' . $ses_rest_id . '_' . $array_sel_groups['id']] == '') {
                                                                        ?>
                                                                        <label class="coupon-check-label">
                                                                            <div id="reward_show_span">
                                                                                <input type="checkbox" id="have_group_reward" name="have_group_reward" onClick="open_group_reward_div('<?php echo $array_sel_groups['id']; ?>');" class="regular-checkbox big-checkbox">
                                                                                <label for="have_group_reward"></label>
                                                                                I want to use my Reward Points</div>
                                                                        </label>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <div class="clear"></div>
                                                            <div id="reward_div_group_<?php echo $array_sel_groups['id']; ?>" style="display:none;">
                                                                <input type="text" name="group_reward_point" id="group_reward_point_<?php echo $array_sel_groups['id']; ?>" class="profilefield_right" style="float:left; width:168px;  padding:5px; margin:4px 9px 8px 9px;" onKeyPress="return goodchars(event, '1234567890');" >
                                                                <input type="button" class="check_order_button" name="reward_point_submit" value="Apply" style="text-decoration: none; margin-top: 3px; margin-left: -1px; padding: 8px 22px; float:left;" onClick="get_reward_point_group('<?php echo $total_amt; ?>', '<?php echo $_REQUEST['id']; ?>', '<?php echo $array_sel_groups['id']; ?>');">
                                                            </div>
                                                            <script>
                                                                function open_group_reward_div(val) {
                                                                    var $j = jQuery.noConflict();
                                                                    if ($j('input[name="have_group_reward"]').prop("checked") == true) {
                                                                        $j("#reward_div_group_" + val).slideDown(1000);
                                                                    } else {
                                                                        $j("#reward_div_group_" + val).slideUp(1000);
                                                                    }
                                                                }

                                                                function change_group_reward(val) {
                                                                    var $j = jQuery.noConflict();
                                                                    $j("#reward_div_group_" + val).slideDown(1000);
                                                                    $j("#reward_point_span_group_" + val).hide(1000);
                                                                }

                                                                function get_reward_point_group(amount, res_id, val) {
                                                                    if ($j("#group_reward_point_" + val).val() == '')
                                                                    {
                                                                        alert("This Field cannot be left Blank!!");
                                                                        $j("#group_reward_point_" + val).focus();
                                                                        return false;
                                                                    } else {
                                                                        var reward_point = $j("#group_reward_point_" + val).val();
                                                                        $j.ajax({
                                                                            url: 'reward_ajax_group.php',
                                                                            type: 'POST',
                                                                            data: 'reward_point=' + reward_point + '&res_id=' + res_id + '&amount=' + amount,
                                                                            //dataType : 'json',
                                                                            beforeSend: function (jqXHR, settings) {
                                                                                //alert(url);
                                                                            },
                                                                            success: function (data, textStatus, jqXHR) {
                                                                                if (data != '') {
                                                                                    window.location.href = "https://foodandmenu.com/restaurant.php?id=" + res_id;
                                                                                }
                                                                            },
                                                                            /*complete : function(jqXHR, textStatus){
                                                                             alert(3);
                                                                             },*/
                                                                            error: function (jqXHR, textStatus, errorThrown) {
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                            </script>
                                                                <?php } ?>
                                                        <div class="clear"></div>
                                                        <div class="small friend-subtotal">Tax: <span class="friend-subtotal-total">
                                                                <?php
                                                                $tax_amt = ($sql_restaurant_delivery_details1['tax'] / 100 * $total_amt);
                                                                $tax_amt1 = round($tax_amt, 2);
                                                                echo "$" . round($tax_amt1, 2);
                                                                ?>
                                                            </span> </div>
                                                        <?php if ($_SESSION['coupon_discount' . $ses_rest_id . "_" . $array_sel_groups['id']] != '') { ?>
                                                            <div class="small friend-subtotal">Coupon Discount: <span class="friend-subtotal-total"> <?php echo "$" . $_SESSION['coupon_discount' . $ses_rest_id . "_" . $_SESSION['group_order_details_id' . $ses_rest_id]]; ?> </span> </div>
                                                        <?php } ?>
                                                        <?php if ($_SESSION['reward_point' . $ses_rest_id . "_" . $array_sel_groups['id']] != '') { ?>
                                                            <div class="small friend-subtotal">Reward Point Discount: <span class="friend-subtotal-total"> <?php echo "$" . $_SESSION['reward_point' . $ses_rest_id . "_" . $_SESSION['group_order_details_id' . $ses_rest_id]]; ?> </span> </div>
                                                        <?php } ?>
                                                        <?php
                                                        if ($_REQUEST['type'] == 'del' || (isset($_SESSION['del_charge' . $ses_rest_id . '_' . $array_sel_groups['id']]))) {
                                                            $del_blk_dis = "block";
                                                            $del_blkdis1 = "none";
                                                        } else {
                                                            $del_blk_dis = "none";
                                                            $del_blkdis1 = "block";
                                                        }
                                                        ?>
                                                                    <?php if ($_SESSION['del_charge' . $ses_rest_id . '_' . $array_sel_groups['id']] != '') { ?>
                                                            <div id="del_crge<?php echo $_SESSION['group_order_details_id' . $ses_rest_id]; ?>" style="display:<?php echo $del_blk_dis; ?>">
                                                                <div class="small friend-subtotal del_crge">Delivery Charge: <span class="friend-subtotal-total">$
                                                                        <?php
                                                                        $delivery_crge_grp = $_SESSION['del_charge' . $ses_rest_id . '_' . $array_sel_groups['id']];
                                                                        echo $delivery_crge_grp;
                                                                        ?>
                                                                    </span> </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($sql_restaurant_delivery_details1['service_fee'] != '') { ?>
                                                            <div class="small friend-subtotal">Service Fee: <span class="friend-subtotal-total">$<?php echo $sql_restaurant_delivery_details1['service_fee']; ?> </span> </div>
                                                        <?php } ?>
                                                        <?php
                                                        $sub_total_amt = $total_aft_coupon_dis + $tax_amt1 + $sql_restaurant_delivery_details1['service_fee'];
                                                        $sub_total_del = $total_aft_coupon_dis + $tax_amt1 + $_SESSION['del_charge' . $ses_rest_id . '_' . $array_sel_groups['id']] + $sql_restaurant_delivery_details1['service_fee'];
                                                        ?>
                                                        <div class="small friend-subtotal">Subtotal: <span class="friend-subtotal-total">$<?php echo $total_aft_coupon_dis; ?></span></div>
                                                        <div class="small friend-subtotal total_ammt" id="" style="display:<?php echo $del_blkdis1; ?>">Total: <span class="friend-subtotal-total">$<?php echo $sub_total_amt; ?></span></div>
                                                        <div class="small friend-subtotal total_del" id="" style="display:<?php echo $del_blk_dis; ?>">Total: <span class="friend-subtotal-total">$<?php echo $sub_total_del; ?></span></div>
        <?php } else {
            ?>
                                                        <div class="cart_empty">
                                                            <p>Cart is Empty</p>
                                                        </div>
                                                <?php } ?>
                                                </div>
                                                <div class="clear"></div>
                                                <?php
                                                $coupon_diss = $coupon_diss + $_SESSION['coupon_discount' . $ses_rest_id . "_" . $array_sel_groups['id']];
                                                $reward_point_dis = $reward_point_dis + $_SESSION['reward_point' . $ses_rest_id . "_" . $array_sel_groups['id']];
                                                $total_tax = $total_tax + $tax_amt1;
                                                $total_sub_total = ($total_sub_total + $total_amt - $coupon_diss - $reward_point_dis);
                                                $total_del_charge = ($total_del_charge + $_SESSION['del_charge' . $ses_rest_id . '_' . $array_sel_groups['id']]);
                                                $grand_total = ($grand_total + $sub_total_amt);
                                                $grand_total_del = ($grand_total_del + $sub_total_del);
                                                $service_fee = $service_fee + $sql_restaurant_delivery_details1['service_fee'];


                                                if ($array_sel_groups['id'] == $_SESSION['group_order_details_id' . $ses_rest_id]) {
                                                    $_SESSION['total_amt' . $array_sel_groups['id']] = $sub_total_amt;
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="cost_summary" id="totalblock">
                                            <div class="f_clear"> Tax: <span>$<?php echo $total_tax; ?></span> </div>
                                            <?php if ($coupon_diss != '0') { ?>
                                                <div class="f_clear"> Coupon Discount: <span>$<?php echo $coupon_diss; ?></span> </div>
                                            <?php } ?>
                                            <?php if ($reward_point_dis != '0') { ?>
                                                <div class="f_clear"> Reward Point Discount: <span>$<?php echo $reward_point_dis; ?></span> </div>
                                            <?php } ?>
                                            <?php if ($service_fee != '0') { ?>
                                                <div class="f_clear"> Service Fee: <span>$<?php echo $service_fee; ?></span> </div>
                                            <?php } ?>
                                            <div class="f_clear" style="display:<?php echo $del_blk_dis; ?>" id="final_del_div"> Delivery Charge: <span>$<?php echo $total_del_charge; ?></span> </div>
                                            <div class="f_clear"> Global Subtotal: <span>$<?php echo $total_sub_total; ?></span> </div>
                                            <?php
                                            if ($_REQUEST['type'] == 'del' || ($coupon_diss != '0')) {
                                                $del_blk_div = 'none';
                                                $del_blk_div1 = 'block';
                                            } else {
                                                $del_blk_div = 'block';
                                                $del_blk_div1 = 'none';
                                            }
                                            ?>
                                            <div class="f_clear" id="total" style="display:<?php echo $del_blk_div; ?>"> Global Total: <span>$<?php echo $grand_total; ?></span> </div>
                                            <div class="f_clear" id="total_del" style="display:<?php echo $del_blk_div1; ?>"> Global Total: <span>$<?php echo $grand_total_del; ?></span> </div>
                                        </div>
                                        <?php
                                        $sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $_REQUEST['id'] . "'"));
                                        $address = $sql_select_add['restaurant_address'] . " " . $sql_select_add['restaurant_city'] . " " . $sql_select_add['restaurant_state'] . " " . $sql_select_add['restaurant_zipcode'];

                                        $timezone = getTimezone($address);

                                        if ($timezone != '') {
                                            date_default_timezone_set($timezone);
                                        } else {
                                            date_default_timezone_set('America/Chicago');
                                        }

                                        $current_time = date('h:i A');

                                        $today = date('l');

                                        $day = strtolower(substr($today, 0, 3));

                                        $time_from = $sql_del_time['business_hours_' . $day . '_from'];
                                        $time_to = $sql_del_time['business_hours_' . $day];

                                        $current_time1 = DateTime::createFromFormat('H:i A', $current_time);
                                        $time1 = DateTime::createFromFormat('H:i A', $time_from);
                                        $time2 = DateTime::createFromFormat('H:i A', $time_to);

                                        $sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '" . $sql_select_add['id'] . "' AND holiday_date = '" . date('Y-m-d') . "'");
                                        $restaurant_holiday = '';
                                        while ($array_holidays = mysql_fetch_array($sql_holidays)) {
                                            $holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
                                            $holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);

                                            if ($current_time1 > $holiday_from && $current_time1 < $holiday_to) {
                                                $restaurant_holiday = 'close';
                                            }
                                        }


                                        if ($restaurant_holiday != 'close') {
                                            $sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '" . strtolower($today) . "'"));
                                            $sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $sql_select_add['id'] . "'");
                                            $restaurant_status = '';
                                            while ($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)) {
                                                $new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
                                                $new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);

                                                if ($current_time1 > $new_from_tm && $current_time1 < $new_to_tm) {
                                                    $restaurant_status = 'open';
                                                }
                                            }
                                        } else {
                                            $restaurant_status = '';
                                        }

                                        $sql_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $sql_select_add['id'] . "'");
                                        $restaurant_pickup_status = '';
                                        while ($array_pickup_hrs = mysql_fetch_array($sql_pickup_hrs)) {
                                            $pickup_from_tm = DateTime::createFromFormat('H:i A', $array_pickup_hrs['time_from']);
                                            $pickup_to_tm = DateTime::createFromFormat('H:i A', $array_pickup_hrs['time_to']);

                                            if ($current_time1 > $pickup_from_tm && $current_time1 < $pickup_to_tm) {
                                                $restaurant_pickup_status = 'open';
                                            }
                                        }


                                        $sql_delivery_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $sql_select_add['id'] . "'");
                                        $restaurant_delivery_status = '';
                                        while ($array_delivery_hrs = mysql_fetch_array($sql_delivery_hrs)) {
                                            $delivery_from_tm = DateTime::createFromFormat('H:i A', $array_delivery_hrs['time_from']);
                                            $delivery_to_tm = DateTime::createFromFormat('H:i A', $array_delivery_hrs['time_to']);

                                            if ($current_time1 > $delivery_from_tm && $current_time1 < $delivery_to_tm) {
                                                $restaurant_delivery_status = 'open';
                                            }
                                        }
                                        ?>
                                        <div class="cost_summary" id="totalblock">
                                            <div class="f_clear">
                                                <div class="pick_delvry_left">
                                                    <input type="radio" name="del_method_grp" id="pickup_grp" value="pickup" onClick="enable_checkout(this.value);" <?php if ($restaurant_pickup_status != 'open') { ?> disabled <?php } ?> />
                                                    PICKUP <img src="images/pickup.png"> </div>
                                                <div class="pick_delvry_right">
                                                    <input type="radio" name="del_method_grp" id="del_grp" value="delivery" <?php if ($_REQUEST['type'] == 'del') { ?> checked = "checked" <?php } ?> <?php if (($_SESSION['total_amt' . $_SESSION['group_order_details_id' . $ses_rest_id]] < $sql_restaurant_delivery_details1['minimum_ammount']) || $restaurant_delivery_status != 'open') { ?> disabled <?php } ?> onClick="enable_checkout(this.value);">
                                                    DELIVERY <img src="images/delivery.png"> 
                                                    </div>
                                                <div class="clear"></div>
                                            </div>
                                            <?php if ($_SESSION['del_charge' . $ses_rest_id . '_' . $_SESSION['group_order_details_id' . $ses_rest_id]] != '') { ?>
                                                <a href="javascript:void(0);" onClick="open_del_crg_div();" >Change Delivery Address</a>
                                        <?php } ?>
                                        </div>
                                        <?php if ($restaurant_pickup_status != 'open') { ?>
                                            <p style="color:#C00007; font-size:16px; margin-left:20px;">Not taking orders for pickup at this time.</p>
                                        <?php } ?>
                                        <?php if ($restaurant_delivery_status != 'open') { ?>
                                            <p style="color:#C00007; font-size:16px; margin-left:20px;">Not taking orders for delivery at this time.</p>
    <?php } ?>
                                        <script>
                                            function enable_checkout(val) {
                                                var $j = jQuery.noConflict();
                                                if (val == 'pickup') {
                                                    $j('#checkout_enabled_btn_pickup').show();
                                                    $j('#checkout_disabled_btn').hide();
                                                    $j('#checkout_enabled_btn_delivery').hide();
                                                    $j('#final_del_div').hide(1000);
                                                    $j('.del_crge').hide(1000);
                                                    $j('.total_del').hide(1000);
                                                    $j('#total_del').hide(1000);
                                                    $j('.total_ammt').show(1000);
                                                    $j('#total').show(1000);
                                                } else {
                                                    $j('#checkout_enabled_btn_pickup').hide();
                                                    $j('#checkout_disabled_btn').hide();
                                                    $j('#checkout_enabled_btn_delivery').show();
                                                    $j('#final_del_div').show(1000);
                                                    $j('.del_crge').show(1000);
                                                    $j('.total_del').show(1000);
                                                    $j('#total_del').show(1000);
                                                    $j('.total_ammt').hide(1000);
                                                    $j('#total').hide(1000);
                                                }
                                            }

                                            function open_del_crg_div() {
                                                var $j = jQuery.noConflict();
                                                /*$j("#del_add_grp1").show();
                                                 $j("#fade").show();	*/

                                                document.getElementById('fade').style.display = "block";
                                                document.getElementById('del_add_grp1').style.display = "block";
                                                $j('html, body').animate({scrollTop: $j('#del_add_grp1').offset().top - 150}, '100');
                                            }

                                            function closedel_add_grp() {
                                                var $j = jQuery.noConflict();
                                                $j("#del_add_grp1").hide();
                                                $j("#fade").hide();
                                            }
                                        </script>
                                        <?php if ($sql_restaurant_delivery_details1['minimum_ammount'] != '') { ?>
                                            <p style="margin-left:20px;">Delivery Minimum : $<?php echo $sql_restaurant_delivery_details1['minimum_ammount']; ?> (Before tax)</p>
                                        <?php } ?>
                                        <p style="margin-left:20px;">No minimum on pickup orders</p>
                                        <br>
                                        <?php
                                        if ($_REQUEST['type'] == 'del') {
                                            $del_sty_blk = 'block';
                                            $del_sty_blk1 = 'none';
                                        } else {
                                            $del_sty_blk = 'none';
                                            $del_sty_blk1 = 'block';
                                        }
                                        ?>
                                        <?php
                                        if ($_SESSION['customer_id'] == '') {
                                            $pickup_lnk = 'login.php?checkout_type=pickup';
                                        } else {
                                            $pickup_lnk = 'check_out.php?type=pickup';
                                        }
                                        ?>
                                        <?php
                                        if ($_SESSION['del_charge' . $ses_rest_id . '_' . $_SESSION['group_order_details_id' . $ses_rest_id]] == '') {
                                            $delivery_lnk = 'javascript:void(0)';
                                        } else {
                                            if ($_SESSION['customer_id'] == '') {
                                                $delivery_lnk = 'login.php?checkout_type=del';
                                            } else {
                                                $delivery_lnk = 'check_out.php?type=del';
                                            }
                                        }
                                        ?>
                                        <?php
                                        if ($restaurant_status == 'open') {
                                            if ($restaurant_pickup_status == 'open' || $restaurant_delivery_status == 'open') {
                                                ?>
                                                <div id="checkout_disabled_btn" style="display:<?php echo $del_sty_blk1; ?>"> <a href="javascript:void(0);" class="checkout_grey" id="summary_btn"> CHECKOUT </a> </div>
                                                <div id="checkout_enabled_btn_pickup" style="display:none;"> <a href="<?php echo $pickup_lnk; ?>" class="checkout_blue" id="summary_btn"> CHECKOUT </a> </div>
                                                <div id="checkout_enabled_btn_delivery" style="display:<?php echo $del_sty_blk; ?>;"> <a href="<?php echo $delivery_lnk; ?>" class="checkout_blue" id="summary_btn" <?php if ($_SESSION['del_charge' . $ses_rest_id . '_' . $_SESSION['group_order_details_id' . $ses_rest_id]] == '') { ?> onClick="open_del_crg_div();" <?php } ?> > CHECKOUT </a> </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script> 
                                    <script>

                                            function initialize() {

                                                var markers = [];
                                                var map = new google.maps.Map(document.getElementById('map-canvas_grp'), {
                                                });
                                                var input = (
                                                        document.getElementById('address_grp'));
                                                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                                                var searchBox = new google.maps.places.SearchBox(
                                                        (input));
                                                google.maps.event.addListener(searchBox, 'places_changed', function () {
                                                    var places = searchBox.getPlaces();
                                                    if (places.length == 0) {
                                                        return;
                                                    }

                                                });
                                                google.maps.event.addListener(map, 'bounds_changed', function () {
                                                    var bounds = map.getBounds();
                                                    searchBox.setBounds(bounds);
                                                });
                                            }

                                            google.maps.event.addDomListener(window, 'load', initialize);</script>
                                    <form name="frm" method="post" action="">
                                        <input type="hidden" name="hid_rest_id" id="hid_rest_id" value="<?php echo $_REQUEST['id']; ?>">
                                        <div class="pop_item2" style="display:none; margin:250px 0 0 0;" id="del_add_grp1">
                                            <h2>Where are you?<a href="Javascript:void(0);" onClick="closedel_add_grp()" style="margin-left:425px;"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                            <h3>We want to make sure this restaurant is convenient for delivery or pickup.</h3>
                                            <h3>Please enter your address </h3>
                                            <input name="address_grp" id="address_grp" type="text" class="pop_quantity" style="width:350px; margin:10px !important; font-family: Calibri !important; font-size:14px;" placeholder="Enter Address" />
                                            <div id="map-canvas_grp"></div>
                                            <div>
                                                <input name="submit_del_grp" id="submit" type="submit" value="VERIFY ADDRESS" class="pop_button" style="width:150px;" />
                                            </div>
                                        </div>
                                    </form>

									
									
                                    <!-----------------------------------  GROUP CART  ------------------------------------------>
<?php } ?>
                                <!--<div style="margin-bottom:5px;" id="show_map"> <a href="javascript:void(0);" onClick="return show_map();">
                                        <h4>Show Map</h4>
                                    </a> </div>
                                <div style="margin-bottom:5px; display:none;" id="hide_map"> <a href="javascript:void(0);" onClick="return show_map();">
                                        <h4>Hide Map</h4>
                                    </a> </div>-->
                                <div style="width: 320px; height:200px; margin-bottom:10px; border:1px solid rgb(255, 177, 113); display:none;" id="map_div">
                                    <iframe width="320" height="200" src="http://regiohelden.de/google-maps/map_en.php?width=320&amp;height=200&amp;hl=en&amp;q=<?php echo $address_map; ?>%20+(<?php echo stripslashes($sql_select_add['restaurant_name']) ?>)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <!-- <div class="clear"></div>--> 
                    </div>
                    <div class="clear"></div>
                    <div class="tab_body_cont"></div>
                    <div class="body_footer_bg"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
        $share_no = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50), 1) . substr(md5(time()), 1);
        ?>
        <div id="shared_div" style="display:none;" class="white_content wht_cont_pop"  >
            <div class="slide_head">
                <h1>Group Order by Food and Menu</h1>
            </div>
            <div class="close close-new" onClick="close_shared_cart();"><a href = "javascript:void(0);"> </a> </div>
            <div class="l-contnt up-contnt">
                <form name="group_order_form" id="group_order_form" enctype="multipart/form-data" action="" method="post" onSubmit="return check_val();">
                    <p><span>Name</span>
                        <input type="text" name="name" id="name" placeholder="Your Name" class="restaurant" />
                    </p>
                    <p><span>Email</span>
                        <input type="text" name="email_adm" id="email_adm" placeholder="Your Email" class="restaurant">
                    </p>
                    <p><span>Share Link</span>
                        <input type="text" name="share_link" id="share_link" class="restaurant" value="https://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']; ?>&share=<?php echo $share_no; ?>" readonly />
                    </p>
                    <p>
                        <input type="hidden" id="link" value="<?php echo $share_no; ?>">
                    </p>
                    <div class="clear"></div>
                    <p><span class="link_code">Or share link by</span></p>
                    <div class="clear"></div>
                    <p class="mail_para"><a href="javascript:void(0);" id="email_a" onClick="email_div_show()" class="mail_txt">Email</a></p>
                    <div class="clear"></div>
                    <div id="email_div" style="display:none;">
                        <input type="text" name="email" id="email" placeholder="Enter the Email" class="restaurant">
                        <input type="button" name="send" id="send" value="Send" onClick="send_email();" class="email_send">
                    </div>
                    <input type="submit" name="submit" id="submit" value="Start Your Order" class="order_butt">
                </form>
            </div>
        </div>
        <?php
        if ($_REQUEST['is_admin'] == "0" && $_SESSION['group_order_details_id' . $ses_rest_id] == "") {
            $display2 = "block";
        } else {
            $display2 = "none";
        }
        ?>
        <?php
        $url = "https://foodandmenu.com/restaurant.php?id=" . $_REQUEST['id'] . "&share=" . $_REQUEST['share'];
        $group_order_id = getNameTable("restaurant_group_order", "id", "share_link", $url);
        $adm_name = getNameTable("restaurant_group_order_details", "name", "group_order_id", $group_order_id, "is_admin", "1");
        $res_name = getNameTable("restaurant_basic_info", "restaurant_name", "id", $_REQUEST['id']);
        ?>
        <div id="group_add_div" style="display:<?php echo $display2; ?>;" class="white_content wht_cont_pop"  >
            <div class="slide_head">
                <h1>Group Order by Food and Menu</h1>
            </div>
            <div class="l-contnt up-contnt up-cont-2">
                <h2>Joining <?php echo $adm_name; ?>'s Shared Cart</h2>
                <h3>for <?php echo $res_name; ?></h3>
                <form name="group_order_join_form" id="group_order_join_form" enctype="multipart/form-data" action="" method="post" onSubmit="return check_valid();">
                    <p> <span>Name</span>
                        <input type="text" name="chld_name" id="chld_name" placeholder="Your Name" class="restaurant" />
                    </p>
                    <div class="clear"></div>
                    <input type="hidden" name="share_link_hid" id="share_link_hid" value="<?php echo $url; ?>" />
                    <input type="hidden" name="group_order_id_hid" id="group_order_id_hid" value="<?php echo $group_order_id; ?>" />
                    <div class="grp_start">
                        <input type="submit" name="submit" id="submit" value="Start" class="grp_sub">
                    </div>
                </form>
            </div>
        </div>
        <div id="fade1" class="black_overlay" style="display:<?php echo $display2; ?>"> </div>
        <div id="sidetab">
            <div id="login-poup-area"> <a href="close" id="video_close"><img src="images/close.png" width="32" height="32" alt="" style="position:absolute; z-index:11111; cursor:pointer; right:-7px; top:-6px;"></a>
                <div class="newpopup">
                    <div class="popcontent" id="video_content"></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function count_down(id)
            {
                var $j = jQuery.noConflict();
                count = $j("#quantity" + id).val();
                price = $j("#hid_prc_menu" + id).val();
                if (count != parseInt(1))
                {
                    new_count = parseInt(count) - parseInt(1);
                    new_price = new_count * parseFloat(price);
                    $j("#quantity" + id).val(new_count);
                    $j("#menu_prc" + id).html(new_price.toFixed(2));
                }
                else
                {
                    alert("You cannot order 0 Quantity!");
                }
            }

            function count_up(id)
            {
                var $j = jQuery.noConflict();
                count = $j("#quantity" + id).val();
                price = $j("#hid_prc_menu" + id).val();
                new_count = parseInt(count) + parseInt(1);
                new_price = new_count * parseFloat(price);
                $j("#quantity" + id).val(new_count);
                $j("#menu_prc" + id).html(new_price.toFixed(2));
            }

            function open_shared_cart()
            {
                var $j = jQuery.noConflict();
                $j("#shared_div").show();
                $j("#fade1").show();
            }

            function close_shared_cart()
            {
                var $j = jQuery.noConflict();
                $j("#shared_div").hide();
                $j("#fade1").hide();
            }

            function email_div_show()
            {
                var $j = jQuery.noConflict();
                $j("#email_a").hide();
                $j("#email_div").fadeIn(1000);
            }

			function open_accor(id)
			{
				var $j = jQuery.noConflict();
				if($j("#sub_cat_sidebox"+id).css('display') == 'none')
				{
					$j(".sub_cat_sidebox").slideUp();
					$j(".cat_a_sidebox").html('<i class="fa fa-plus"></i>');
					$j("#sub_cat_sidebox"+id).slideDown(1000);
					$j("#cat_a_sidebox"+id).html('<i class="fa fa-minus"></i>');
				}
				else
				{
					$j("#sub_cat_sidebox"+id).slideUp(1000);
					$j("#cat_a_sidebox"+id).html('<i class="fa fa-plus"></i>');
				}
			}

            function send_email()
            {
                var $j = jQuery.noConflict();
                $j.ajax({
                    url: 'send_group_mail.php',
                    type: 'POST',
                    data: 'email=' + $j("#email").val() + '&res_id=' + <?php echo $_REQUEST['id']; ?> + '&share_link=' + $j("#link").val(),
                    //dataType : 'json',
                    beforeSend: function (jqXHR, settings) {
                        //alert(url);
                    },
                    success: function (data, textStatus, jqXHR) {
                        //alert(data);
                        if (data == "success")
                        {
                            alert("Your Link is on the Way! Enjoy!");
                            $j("#email_div").hide();
                            $j("#email_a").fadeIn(1000);
                        }
                    },
                    /*complete : function(jqXHR, textStatus){
                     alert(3);
                     },*/
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
            function email_top_div_show()
            {
                var $j = jQuery.noConflict();
                $j("#email_top_a").hide();
                $j("#email_top_div").fadeIn(1000);
            }
            function send_top_email()
            {
                var $j = jQuery.noConflict();
                $j.ajax({
                    url: 'send_group_top_mail.php',
                    type: 'POST',
                    data: 'email=' + $j("#email_top").val() + '&res_id=' + <?php echo $_REQUEST['id']; ?> + '&share_link=' + $j("#link_top").val(),
                    //dataType : 'json',
                    beforeSend: function (jqXHR, settings) {
                        //alert(url);
                    },
                    success: function (data, textStatus, jqXHR) {
                        //alert(data);
                        if (data == "success")
                        {
                            alert("Your Mail is on the Way! Enjoy!");
                            $j("#email_top_div").hide();
                            $j("#email_top_a").fadeIn(1000);
                        }
                    },
                    /*complete : function(jqXHR, textStatus){
                     alert(3);
                     },*/
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
            function check_val()
            {
                if ($j("#name").val() == "")
                {

                    alert("Name Field is Required");
                    $j("#name").focus()
                    return false;
                }
                else if ($j("#email_adm").val() == "")
                {
                    alert("Email Field is Required");
                    $j("#email_adm").focus()
                    return false;
                }
            }

            function check_valid()
            {
                if ($j("#chld_name").val() == "")
                {

                    alert("Name Field is Required");
                    $j("#chld_name").focus()
                    return false;
                }
            }
			
			/*function open_subcat_accor(id)
			{
				var $j = jQuery.noConflict();
				$j(".accordion_toggle").removeClass('accordion_toggle_active');
				$j(".accordion_content"+id).css({'display':'block'});
				$j("#accor_subcat"+id).addClass('accordion_toggle_active');
				$j('#div_subcat_content'+id).css({'display':'block','height':'auto'});
			}*/
        </script> 
        <script type="text/javascript" src="javascript/prototype.js"></script> 
        <script type="text/javascript" src="javascript/effects.js"></script> 
        <script type="text/javascript" src="javascript/accordion.js"></script> 
        <script type="text/javascript" src="javascript/code_highlighter.js"></script> 
        <script type="text/javascript" src="javascript/javascript.js"></script> 
        <script type="text/javascript" src="javascript/html.js"></script> 
        <script type="text/javascript">

            // 
            //  In my case I want to load them onload, this is how you do it!
            // 
            Event.observe(window, 'load', loadAccordions, false);
            //
            //	Set up all accordions
            //
            function loadAccordions() {

                var bottomAccordion = new accordion('vertical_container');
                // Open first one
                bottomAccordion.activate($$('#vertical_container .accordion_toggle')[0]);
                // Open second one
                topAccordion.activate($$('#horizontal_container .horizontal_accordion_toggle')[2]);
            }

        </script>
<?php include("includes/footer_new.php"); ?>
        <script type="text/javascript">
            if (document.getElementById('pickup').checked == true) {
                var type = 'pickup';
            } else {
                var type = 'del';
            }
            del_type(type);</script>
        <?php
        if ($_SESSION['coupon_code' . $ses_rest_id] != '') {
            ?>
            <script type="text/javascript">
                check_coupon_session();</script>
            <?php
        }


        if ($_SESSION['reward_point' . $ses_rest_id] != '') {
            ?>
            <script type="text/javascript">
                check_reward_session();
            </script>
            <?php
        }
        ?>
<?php if($_REQUEST['sbcat_id'] != "") { ?>
<script type="text/javascript">open_subcat_accor('<?php echo $_REQUEST['sbcat_id']; ?>');</script>
<?php } ?>

<script src="jquery/jquery.slicknav.js"></script>