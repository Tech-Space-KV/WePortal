<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require('connection.php');

if(isset($_POST['submit']))
    {
             $username=$_POST['username'];
	         $password=sha1($_POST['password']);
        
			$query="select * from `admin_login` where `login_flag` = 'true' and `username`='".$username."' and `password`='".$password."' ";
            $result=mysqli_query($con,$query);
			        if (mysqli_num_rows($result)==0) 
					{
					echo "<script>
					alert('Wrong username or password');
					window.location.href = 'index.php';</script>";
						exit;
					}
					elseif (mysqli_num_rows($result)>0)
					{
					    while( $row=mysqli_fetch_assoc($result))
				        {
				             $_SESSION['_tp_name']=$row['username'];
				             $_SESSION['_tp_flag']='true';
				             echo "<script>window.location.href = 'dashboard.php';</script>";
				        }
					}
					else{
					    	echo "<script>
					alert('Something went wrong');
					window.location.href = 'index.php';</script>";
						exit;
					}
        
    }
    
?>