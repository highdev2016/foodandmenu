<?php
/*
	* get admin info
	* @param
	* return value array
*/
if(!function_exists(getAdminInfo)){
	function getAdminInfo()
	{
		$admin_info = array();
		$sql = sprintf("SELECT * FROM `restaurant_admin` WHERE `status` = '%d'", 1);
		$query = mysql_query($sql);
		if(mysql_num_rows($query)>0){
			while( $result = mysql_fetch_array($query) )
			{
				$admin_info['id'] = $result['id']; 
				$admin_info['username'] = $result['username']; 
				$admin_info['email_id'] = $result['email_id']; 
				$admin_info['creation_date'] = $result['creation_date']; 
				$admin_info['modified_date'] = $result['modified_date']; 
				$admin_info['nicename'] = $result['nicename']; 
			}
		}
		return $admin_info;
	}
}

/*
	* get restaurant category
	* @param
	* return value string
*/
if(!function_exists(getContactSubject)){
	function getContactSubject($catid)
	{
		$rest_cat = array(
							1=>'Registration Request',
							2=>'General Enquiry',
							3=>'Grievance'
		);		
		return $rest_cat[$catid];
	}
}


/*
	* get restaurant category
	* @param
	* return value string
*/
if(!function_exists(getContactCategory)){
	function getContactCategory($subid, $catid)
	{
		$rest_cat = array(
							1=> array( 1=>'Register my restaurant', 2=>'Register as a vendor' ),
							2=> array( 1=>'Reservation Information', 2=>'Usability Information', 3=>'Others' ),
							3=> array( 1=>'Customer Feedback', 2=>'Vendor Feedback', 3=>'Restaurant Owner Feedback' )
		);		
		return $rest_cat[$subid][$catid];
	}
}

/*
	* create new user
	* @param array
	* return value int
*/
if(!function_exists(createUser)){
	function createUser($data)
	{
		$sql = "INSERT INTO `restaurant_users` SET ";
		foreach( $data as $key => $val )
		{
			$sql .= $key ."='".$val."',";
		}
		$sql = trim($sql);
		$sql = preg_replace('/,$/','',$sql);
		mysql_query($sql);
		return mysql_insert_id();
	}
}
/*
	* update user
	* @param array, int
	* return value boolean
*/
if(!function_exists(updateUser)){
	function updateUser($data, $id)
	{
		$sql = "UPDATE `restaurant_users` SET ";
		foreach( $data as $key => $val )
		{
			$sql .= $key ."='".$val."',";
		}
		$sql = trim($sql);
		
		$sql = preg_replace('/,$/','',$sql);
		$sql .= " WHERE `ID` = '".$id."'";
		//echo $sql;
		//exit;
		if(mysql_query($sql))
		return true;
	}
}

/*
	* mail contact request to user
	* @param mailid, request type
	* return value boolean
*/
if(!function_exists(sendMailToUser)){
	function sendMailToUser($data)
	{
		$admin_info = getAdminInfo();
		$to  = $data['user_email'];
		
		// subject
		$subject = "Registration Request approve";
		
		// message
		$message = '
		<html>
		<head>
		  <title>'.$subject.'</title>
		</head>
		<body>
		  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style=" font: 12px/20px Arial, Helvetica, sans-serif; color: #6b6b6b;">
					  <tr>
						<td style="background-color:#EDEDED; height:65px;padding:0 0px;"><table width="700" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="169" height="70" align="center"><img src="https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/images/logo.png" width="147" height="45" alt="" style="margin:0px 0 0 0;" /></td>
							<td width="606">
							<h1 style="font:normal 32px Arial, Helvetica, sans-serif; color:#fff; float:left; padding: 20px 0 0px 95px; margin:0;text-transform:uppercase;">
							<span style="color: #464FA4; float: right; font: 30px Arial,Helvetica,sans-serif; padding-bottom: 19px; padding-left: 179px;">Food and Menu</span></h1></td>
						  </tr>
						  
						</table></td>
					  </tr>
					  <tr>
						<td style="padding: 20px;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" font: 12px/20px Arial, Helvetica, sans-serif; color: #6b6b6b;">
						  <tr>
							<td>Hello '.$data['user_nicename'].',</td>
						  </tr>
						   <tr>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>We are happy to know that your request to create a new restaurant with our site has been approved. <br/>Your login details are given below:</td>
						  </tr>
						  <tr>
							<td height="10"></td>
						  </tr>
						  <tr>
							<td>Email ID: '.$data['user_email'].'</td>
						  </tr>
						  <tr>
							<td>Password: '.$data['user_pass'].'</td>
						  </tr>
						  <tr>
							<td>Please click on the following link to login and create your own restaurant.</td>
						  </tr>
						  <tr>
							<td>https://'.$_SERVER['HTTP_HOST'].'/restaurant-login.php</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>Regards,<br>Food and menu administrator team </td>
						  </tr>
						</table></td>
					  </tr>
					  <tr>
						<td style="background-color:#EDEDED; margin:0px 0 0 0; font: 13px/40px Arial, Helvetica, sans-serif; color: #333; padding-left: 20px; text-align:center;" height="40">&copy; 2013 Restaurant website, All right reserved</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					</table>
		</body>
		</html>
		';
		
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From: '.$subject.' <'.$admin_info['email_id'].'>' . "\r\n";
		
		// Mail it
		if(mail($to, $subject, $message, $headers))
			return true;
		else
			return false;
			
		}
}

/*
	* get single restaurant user info
*/
if(!function_exists($id))
{
	function getRestaurant_User($id)
	{
		$sql = "SELECT * FROM `restaurant_users` WHERE `ID` = '".$id."'";
		$qry = mysql_query($sql);
		$res = mysql_fetch_array($qry);
		return $res; 
	}
}

function getNameTable($table,$col,$field='',$value='',$field1='',$value1='',$field2='',$value2='')
	{
		$query="SELECT ".$col." FROM ".$table." where 1 ";
		if($field!='' && $value!='')
		{
		  $query.="AND ".$field."='".$value."' ";
		}
		if($field1!='' && $value1!='')
		{
		  $query.="AND ".$field1."='".$value1."' ";
		}
		if($field2!='' && $value2!='')
		{
		  $query.="AND ".$field2."='".$value2."' ";
		}
		//echo $query;
		$recordSet = mysql_query($query);
		if(mysql_num_rows($recordSet) > 0)
		{
			$row = mysql_fetch_array($recordSet);
			return $row[$col];
		}
		else
		{
			return "";
		}
	}




?>