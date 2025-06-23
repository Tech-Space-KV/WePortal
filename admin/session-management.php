<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
if(($_SESSION['pt-admin-name']!='' and $_SESSION['pt-admin-login-flag']=='True') )
    {
	
	}
	else
	{
		echo '<script> window.location.href = "../sign-in/"; </script>';
	}
	
?>
