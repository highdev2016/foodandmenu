<?php
if(isset($_FILES['documents'])){

foreach($_FILES['documents']['tmp_name'] as $key => $tmp_name)
{
    $file_name = $key.$_FILES['documents']['name'][$key];
    $file_size =$_FILES['documents']['size'][$key];
    $file_tmp =$_FILES['documents']['tmp_name'][$key];
    $file_type=$_FILES['documents']['type'][$key];  
    move_uploaded_file($file_tmp,"test_images/".time().$file_name);
}
}
?>