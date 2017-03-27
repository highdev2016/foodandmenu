<?php 

ob_start();

session_start();

require_once('lib/conn.php');

$file_name=$_SERVER['REQUEST_URI'];

$sfile=substr($file_name,strrpos($file_name,'/')+1,strlen($file_name));

$p=strrpos($sfile,'?');

if($p>0) $x=strrpos($sfile,'?'); else $x=strlen($sfile);

$cfile=substr($sfile,0,$x);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="shortcut icon" href="https://www.foodandmenu.com/favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Food & menu</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='js/jquery-2.0.2.min.js'></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script src="ckeditor/_samples/sample.js" type="text/javascript"></script>

<!--<link rel="shortcut icon" href="../favicon.ico" />

<link rel="icon" href="../favicon.ico" />-->


</head>



<body>



<div id="wrapper_main">

	<div id="wrapper_in">

      <div id="top">

       	  <div class="logo admin_logo"><a href="index.php"><img alt="auto styles logo" src="images/logo1.png"></a></div>

          <div class="admin_headeing"><p style="color:#404CA1;">Admin Panel</p></div>

          <div class="welcome_header"><p class="welcome_text" style="color:#404CA1;">Welcome to <span class="bold" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold; color:#404CA1;">Food & Menu Admin Panel!</span></p></div>

      </div>

  <?php

   $currentFile = $_SERVER["PHP_SELF"];

    $parts = Explode('/', $currentFile);

    $page= $parts[count($parts) - 1]; 

  ?>    

     <div id="middle">    	

        <div id="menu">        

            <div class="links">

            	<ul id="nav">

                	<li <?php if($page=="index.php"){?> class="current" <?php }?>><a href="index.php">Dashboard</a></li>

                    <li <?php if($page=="change_password.php"){?> class="current" <?php }?>><a href="change_password.php">Change Admin details</a></li>

                    <li><a href="logout.php">Logout</a></li>

                    <div style="clear:both;"></div>

                </ul>

            </div>

        </div>

        

        <div class="dashboard_section">

        	

        	<?php 

			if(isset($_SESSION['admin_id']))

			{

			main();

			}

			else

			{

			header('location:login.php');

			exit;

			}

			//ob_end_flush();

			?>	

   

        </div>

     </div>

    </div>



<div id="footer">

          <div id="footer_inner">

            <div id="copy_right">Copy Right &copy; <?php echo date('Y');?> All Rights Reserved by Food & Menu</div>

              <div class="clear"></div>

          </div>

        </div>



</div>



</body>

</html>

