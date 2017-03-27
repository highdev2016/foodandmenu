<?php
if(empty($_REQUEST['getTimeset'])){ $_REQUEST['getTimeset'] = ''; }
if($_REQUEST['getTimeset']!=''){
	
	echo date('h:ia');
}
?>