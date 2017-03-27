<?php
include "includes/dbconnect.php";
ini_set("display_errors", 1);
error_reporting(E_ALL);
include "foodandmenu_user_class.php";
$resval = new resinfo();
$rescouponval = new rescouponinfo();
$resprofileval = new resprofileinfo();
$resreviewval = new resreviewinfo();
$resginfo = new ginfo();
$reslastdeliveryaddress=new lastdeliveryaddress();

$resdetail = new resdetail();
$rescoupon = new rescoupon();
$resdeals = new resdeals();
$reslogin = new reslogin();
$resaddtocart = new resaddtocart();
$tempaddtocart = new tempaddtocart();

$rescartitems = new rescartitems();
$resdelcartitems = new resdelcartitems();
$rescheckpickupdel = new rescheckpickupdel();
$ressignup = new ressignup();
$resdelcharge = new resdelcharge();
$resforgot_password = new resforgot_password();
$resreview_rating = new resreview_rating();
$reswrite_review = new reswrite_review();
$res_insert_order = new res_insert_order();
$res_reservation = new res_reservation();
$res_rating_reviews = new res_rating_reviews();
$res_update_profile = new res_update_profile();
$res_order_history = new res_order_history();

switch($_REQUEST['case'])
{	
    case "location":
            $all_res=$resval->allResval($_REQUEST);
	break;
	
	case "coupon_valid":
            $all_res=$rescouponval->couponval($_REQUEST);
	break;
	
	case "profile":
            $all_res=$resprofileval->profileval($_REQUEST);
	break;
	
	case "review":
            $all_res=$resreviewval->reviewval($_REQUEST);
	break;
	
		
	
	case "gplus":
	        
	        $data = json_decode(file_get_contents('php://input'), true);
			$all_res=$resginfo->saveg($data);
	break;
	
	case "lastdinfo":
	    
	       $all_res=$reslastdeliveryaddress->ldeliveryaddress($_REQUEST);
	break;
	
	
	
	
	
	
	
			
	case "restaurant_detail":
            $all_res=$resdetail->restaurant_detail($_REQUEST);
	break;
	case "restaurant_coupon":
            $all_res=$rescoupon->restaurant_coupon($_REQUEST);
	break;
	case "restaurant_deals":
            $all_res=$resdeals->restaurant_deals($_REQUEST);
    break;
	case "login":
            $all_res=$reslogin->restaurant_login($_REQUEST);
    break;
	
	case "addtocart":
            
			
			$all_res=$resaddtocart->restaurant_addtocart($_REQUEST);
    break;
	
	
	
	case "addtocart_temp":
            
			$data = file_get_contents('php://input');
			$all_res=$tempaddtocart->restaurant_order_temp($data);
    break;
	
	
	
	
	
	case "cartitems":
            $all_res=$rescartitems->restaurant_cartitems($_REQUEST);
    break;
	case "delcartitems":
            $all_res=$resdelcartitems->restaurant_delcartitems($_REQUEST);
    break;
	case "check_pickup_del":
            $all_res=$rescheckpickupdel->restaurant_checkpickupdel($_REQUEST);
    break;
	case "ressignup":
            $all_res=$ressignup->restaurant_ressignup($_REQUEST);
    break;
	case "resdelcharge":
            $all_res=$resdelcharge->restaurant_resdelcharge($_REQUEST);
    break;
	case "forgot_password":
            $all_res=$resforgot_password->restaurant_resforgot_password($_REQUEST);
    break;
	case "review_rating":
            $all_res=$resreview_rating->restaurant_resreview_rating($_REQUEST);
    break;
	case "write_review":
            $all_res=$reswrite_review->restaurant_write_review($_REQUEST);
    break;
	case "order":
            $all_res=$res_insert_order->restaurant_insert_order($_REQUEST);
    break;
	case "reservation":
            $all_res=$res_reservation->restaurant_reservation($_REQUEST);
    break;
	case "rating_reviews":
            $all_res=$res_rating_reviews->restaurant_rating_reviews($_REQUEST);
    break;
	case "update_profile":
            $all_res=$res_update_profile->restaurant_update_profile($_REQUEST);
    break;
	case "order_history":
            $all_res=$res_order_history->restaurant_order_history($_REQUEST);
    break;
}
echo json_encode($all_res);//str_replace('"0":','',json_encode($all_res));
/*echo '<pre>';
print_r($all_res);*/
?>