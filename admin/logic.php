<?php
session_start();
$error = "";

if(array_key_exists("logout", $_GET))
{
	unset($_SESSION);
	setcookie("id","",time()-60*60);
	$_COOKIE["id"]="";

}
elseif ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id']))
 {
	header("location:loggedinpage.php");
}

if(array_key_exists("submit", $_POST))
{
	$link=mysqli_connect("localhost","root","","sigil");
	if(mysqli_connect_error())
	{
		die("database disconnected");
	}
	
	if(!$_POST['email'])
	{
		$error .="An email address is required";
	}
	$error="";
	if(!$_POST['password'])
	{
		$error .="A password is required";
	}
	if($error !="")
	{
		$error="<p> There were error(s) in your form:</p>".$error;
	}
	else
	{
		if($_POST['signup']=='1')
		{

		





		$query="SELECT id FROM 'users' WHERE email ='".mysqli_real_escape_string($link, $_POST['email'])."'LIMIT 1'";
		$result = mysqli_num_rows($link,$query);

		if(mysqli_num_rows($result)>0)
		{
			$error="That email address is taken";
		}
		else
		{
			$query="INSERT INTO 'users' ('email' , 'password') VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";

			if	(mysqli_query($link,$query))
				{
					$error= "<p>could not sign you up - please try again later.</p>";
				}
				else
				{
					$query="UPDATE 'users' SET password='".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id=".mysqli_insert_id($link)."LIMIT 1";

					mysqli_query($link,$query);

					$_SESSION['id']=mysqli_insert_id($link);

					if($_POST['stayloggedIn']=='1')
					{
						setcookie("id",mysql_insert_id($link), item() + 60*60*24);
					}
					header("location: userprofile.php");
				}
		}

}

else
	{

		$query="SELECT id FROM 'users' WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";

		$result=mysqli_query($link,$query);
		$row=mysqli_fetch_array($result);
		if(isset($row))
		{
			$hashedPassword=md5(md5($row['id']).$_POST['password']);
			if($hashedPassword==$row['password'])
			if($_POST['stayloggedIn']=='1')
					{
						setcookie("id",$row['id'], item() + 60*60*24);
					}
					header("location: userprofile.php");
				    }
			else
				    {
					$error="that email/password does not match";
				    }
		    
		} 
	}

}

?>