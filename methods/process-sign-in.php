<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require('../required/db-connection/connection.php');

if(isset($_POST['sign-in-btn']))
    {
             $email=$_POST['email'];
	         $password=sha1($_POST['password']);
        
			$query="select * from `weusers` where `email`='".$email."' and `password`='".$password."' ";
            $result=mysqli_query($con,$query);
			        if (mysqli_num_rows($result)==0) 
					{
					echo "<script>
					alert('Wrong email or password');
					window.location.href = '../sign-in/index';</script>";
						exit;
					}
					elseif (mysqli_num_rows($result)>0)
					{
					    while( $row=mysqli_fetch_assoc($result))
				        {
				             $_SESSION['pt-admin-name']=$row['username'];
				             $_SESSION['pt-admin-email']=$row['email'];
							 $_SESSION['pt-admin-login-flag']='True';
				             echo "<script>window.location.href = '../admin/index';</script>";
				        }
					}
					else{
					    	echo "<script>
					alert('Something went wrong');
					window.location.href = '../admin/index';</script>";
						exit;
					}
        
    }
    
?>