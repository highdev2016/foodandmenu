<?php
session_start();
$ses_rest_id = $_SESSION['cart_rest_id'];

$_SESSION['user_reward_point'.$ses_rest_id]= '';
$_SESSION['reward_point'.$ses_rest_id] = '';

header("location:restaurant.php?id=".$_REQUEST['id']."");
?>